<?php

namespace App\Domain\ReceiptInfo\Repositories;

use App\Domain\BoughtItemInfo\Entities\BoughtItem;
use App\Domain\ReceiptInfo\Contracts\ReceiptInfoRepositoryInterface;
use App\Domain\ReceiptInfo\DTOs\AnalyzedReceiptDTO;
use App\Domain\ReceiptInfo\DTOs\PaginatedReceiptsDTO;
use App\Domain\ReceiptInfo\Entities\Receipt;
use App\Exceptions\S3UploadException;
use App\Models\BoughtItemsInfo;
use App\Models\ReceiptInfo;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ReceiptInfoRepository implements ReceiptInfoRepositoryInterface
{
    private const PAYER_PERRY = 'perry';
    private const PAYER_HANNAH = 'hannah';
    private const PAYER_BOTH = 'both';

    public function findById($id): ?Receipt
    {
        $receipt_id = $id;
        $receipt = ReceiptInfo::find($receipt_id);
        if (!$receipt) return null;
        // TODO: Make this DRY!!!
        $boughtItems = BoughtItemsInfo::where('receipt_id', $id)->get();
        $boughtItemsCollection = $boughtItems->map(function ($item) {
            return new BoughtItem(
                $item->bought_item_id,
                $item->receipt_id,
                $item->name,
                $item->price,
                $item->payer_name
            );
        });
        $person_1_bought_items = $boughtItemsCollection
            ->filter(function ($item) {
                return $item->getPayerName() === self::PAYER_PERRY;
            })
            ->map(function ($item) {
                return new BoughtItem(
                    $item->getBoughtItemId(),
                    $item->getReceiptId(),
                    $item->getName(),
                    $item->getPrice(),
                    self::PAYER_PERRY
                );
            });
        $person_2_bought_items = $boughtItemsCollection
            ->filter(function ($item) {
                return $item->getPayerName() === self::PAYER_HANNAH;
            })
            ->map(function ($item) {
                return new BoughtItem(
                    $item->getBoughtItemId(),
                    $item->getReceiptId(),
                    $item->getName(),
                    $item->getPrice(),
                    self::PAYER_HANNAH
                );
            });
        $both_bought_items = $boughtItemsCollection
            ->filter(function ($item) {
                return $item->getPayerName() === self::PAYER_BOTH;
            })
            ->map(function ($item) {
                return new BoughtItem(
                    $item->getBoughtItemId(),
                    $item->getReceiptId(),
                    $item->getName(),
                    $item->getPrice(),
                    self::PAYER_BOTH
                );
            });

        return new Receipt(
            $receipt->receipt_id,
            $receipt->title,
            $receipt->image_url,
            $receipt->user_who_paid,
            $receipt->total_amount,
            $receipt->person_1_amount,
            $receipt->person_2_amount,
            $person_1_bought_items,
            $person_2_bought_items,
            $both_bought_items,
            
        );;
    }
    /**
     * @return Collection<int, ReceiptInfo>
     */
    public function findAllReceipts(): Collection
    {
        $receipt = ReceiptInfo::all();
        return $receipt;
    }

    public function getPaginatedReceipts(int $page): PaginatedReceiptsDTO
    {
        $PAGINATION_PER_PAGE = 10;
        $skip = ($page - 1) * $PAGINATION_PER_PAGE;
        
        $receiptInfoCollection = ReceiptInfo::skip($skip)
            ->take($PAGINATION_PER_PAGE)
            ->get();
        return new PaginatedReceiptsDTO(
            receipt_data: $receiptInfoCollection,
            total: ReceiptInfo::count()
        );
    }
    public function storeNewReceiptInfoToDatabase(
        string $title,
        string $userWhoPaid,
        int $totalAmount,
        int $person_1_amount,
        int $person_2_amount,
        array $bought_items,
        int $total_amount,
        UploadedFile $imageFile
    ): ?Receipt
    {
        $imageUrl = '';
        try {
            /** @var \Illuminate\Filesystem\FilesystemAdapter $s3 */
            $s3 = Storage::disk('s3');
            $filename = uniqid() . '.' . $imageFile->getClientOriginalExtension();
            $path = $s3->putFileAs('uploads/images', $imageFile, $filename);
            $imageUrl = $s3->url($path);  
            
            $receipt_info = ReceiptInfo::create([
                'title' => $title,
                'image_url' => $imageUrl,
                'user_who_paid' => $userWhoPaid,
                'total_amount' => $totalAmount,
                'person_1_amount' => $person_1_amount,
                'person_2_amount' => $person_2_amount,
            ]);
        } catch (\RuntimeException $e) {
            Log::error('S3 storage error', [
                'error' => $e->getMessage(),
                'file' => $imageFile->getClientOriginalName()
            ]);
            throw new S3UploadException('Failed to upload image', $imageFile->getClientOriginalName());
        } 
        try {
            // TODO: Fix timezone of the project
            $timestamp_now = now();
            $boughtItemsData = array_map(function($item) use ($receipt_info, $timestamp_now) {
                return [
                    'receipt_id' => $receipt_info->receipt_id,
                    'name' => $item['name'],
                    'price' => $item['price_total'],
                    'payer_name' => $item['who_paid'],
                    'created_at' => $timestamp_now,
                    'updated_at' => $timestamp_now
                ];
            }, $bought_items);
            BoughtItemsInfo::insert($boughtItemsData);
        } catch (\Exception $e) {
            Log::error('S3 storage error', [
                'error' => $e->getMessage(),
                'file' => $imageFile->getClientOriginalName()
            ]);
            throw new \Exception('An unexpected error occurred');
        }
        // TODO: Make this DRY!!!
        $boughtItems = BoughtItemsInfo::where('receipt_id', $receipt_info->receipt_id)->get();
        $boughtItemsCollection = $boughtItems->map(function ($item) {
            return new BoughtItem(
                $item->bought_item_id,
                $item->receipt_id,
                $item->name,
                $item->price,
                $item->payer_name
            );
        });
        $person_1_bought_items = $boughtItemsCollection
            ->filter(function ($item) {
                return $item->getPayerName() === self::PAYER_PERRY;
            })
            ->map(function ($item) {
                return new BoughtItem(
                    $item->getBoughtItemId(),
                    $item->getReceiptId(),
                    $item->getName(),
                    $item->getPrice(),
                    self::PAYER_PERRY
                );
            });
        $person_2_bought_items = $boughtItemsCollection
            ->filter(function ($item) {
                return $item->getPayerName() === self::PAYER_HANNAH;
            })
            ->map(function ($item) {
                return new BoughtItem(
                    $item->getBoughtItemId(),
                    $item->getReceiptId(),
                    $item->getName(),
                    $item->getPrice(),
                    self::PAYER_HANNAH
                );
            });
        $both_bought_items = $boughtItemsCollection
            ->filter(function ($item) {
                return $item->getPayerName() === self::PAYER_BOTH;
            })
            ->map(function ($item) {
                return new BoughtItem(
                    $item->getBoughtItemId(),
                    $item->getReceiptId(),
                    $item->getName(),
                    $item->getPrice(),
                    self::PAYER_BOTH
                );
            });
        return new Receipt(
            $receipt_info->receipt_id,
            $receipt_info->title,
            $receipt_info->image_url,
            $receipt_info->user_who_paid,
            $receipt_info->total_amount,
            $receipt_info->person_1_amount,
            $receipt_info->person_2_amount,
            $person_1_bought_items,
            $person_2_bought_items,
            $both_bought_items
        );

    }
    public function getInfoFromReceiptImage(UploadedFile $imageFile): AnalyzedReceiptDTO
    {
        $apiKey = config('services.openai.apiKey');
        $apiEndpoint = config('services.openai.apiEndpoint');
        if (!$apiKey || !$apiEndpoint) {
            throw new \Exception('OpenAI API configuration is missing');
        }
        $base64Image = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($imageFile));
        try {
            $response = Http::withToken($apiKey, 'Bearer')
                ->post($apiEndpoint . '/v1/chat/completions', [
                    'model' => 'gpt-4.1-mini',
                    'messages' => [
                        [
                            'role' => 'user', 
                            'content' => [
                                [
                                    'type' => 'text',
                                    'text' => "I have a receipt image attached. The left side is the item. The right side is the price. Please ignore phrases like '２コX単', 'スキャンレシ', and ignore discounts on the right side. Please do not add ```json to the final response. Please return the final response in plain text. Can you give receipt information in JSON format based on the typescript interfaces below? ```interface Receipt {  items: Item[]  // 合計  receipt_total: number}interface Item {  name: string  price_total: number}```"
                                ],
                                [
                                    'type' => 'image_url',
                                    'image_url' => [
                                        'url' => $base64Image
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]);
            $responseData = $response->json();
            if (isset($responseData['error']) && $responseData['error']) {
                Log::error(['error message: ' => $responseData['error']['message']]);
                throw new \Exception($responseData['error']['message']);
            }
            Validator::make($responseData, [
                'choices' => 'required|array',
                'choices.0.message.content' => 'required|string',
            ])->validate();
            $openAiContentJson = json_decode($responseData['choices'][0]['message']['content']);
            return new AnalyzedReceiptDTO(
                items: $openAiContentJson->items,
                receipt_total: $openAiContentJson->receipt_total
            );
        } catch (\Exception $e) {
            Log::error('API Request Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
