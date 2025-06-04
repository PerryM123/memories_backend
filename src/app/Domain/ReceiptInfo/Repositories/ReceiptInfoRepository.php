<?php

namespace App\Domain\ReceiptInfo\Repositories;

use App\Domain\BoughtItemInfo\Entities\BoughtItem;
use App\Domain\ReceiptInfo\Contracts\ReceiptInfoRepositoryInterface;
use App\Domain\ReceiptInfo\DTOs\AnalyzedReceiptDTO;
use App\Domain\ReceiptInfo\DTOs\PaginatedReceiptsDTO;
use App\Domain\ReceiptInfo\Entities\Receipt;
use App\Exceptions\S3UploadException;
use App\Infrastructure\OpenAi\Contracts\ReceiptAnalysisServiceInterface;
use App\Models\BoughtItemsInfo;
use App\Models\ReceiptInfo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ReceiptInfoRepository implements ReceiptInfoRepositoryInterface
{
    private const PAYER_PERRY = 'perry';
    private const PAYER_HANNAH = 'hannah';
    private const PAYER_BOTH = 'both';
    private ReceiptAnalysisServiceInterface $ReceiptAnalysisService;

    public function __construct(ReceiptAnalysisServiceInterface $ReceiptAnalysisService)
    {
        $this->ReceiptAnalysisService = $ReceiptAnalysisService;
    }

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
                'image_url' => $path,
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
        Log::info('perry: getInfoFromReceiptImage');
        return $this->ReceiptAnalysisService->getInfoFromReceiptImage($imageFile);
    }
}
