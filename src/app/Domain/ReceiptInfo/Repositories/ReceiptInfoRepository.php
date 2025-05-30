<?php

namespace App\Domain\ReceiptInfo\Repositories;

use App\Domain\BoughtItemInfo\Entities\BoughtItem;
use App\Domain\ReceiptInfo\Contracts\ReceiptInfoRepositoryInterface;
use App\Domain\ReceiptInfo\DTOs\PaginatedReceiptsDTO;
use App\Domain\ReceiptInfo\Entities\Receipt;
use App\Exceptions\S3UploadException;
use App\Models\BoughtItemsInfo;
use App\Models\ReceiptInfo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ReceiptInfoRepository implements ReceiptInfoRepositoryInterface
{
    public function findById($id): ?Receipt
    {
        $receipt_id = $id;
        $receipt = ReceiptInfo::find($receipt_id);
        if (!$receipt) return null;
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
        // TODO: set constants for perry and hannah and both
        $person_1_bought_items = $boughtItemsCollection
            ->filter(function ($item) {
                return $item->getPayerName() === 'perry';
            })
            ->map(function ($item) {
                return new BoughtItem(
                    $item->getBoughtItemId(),
                    $item->getReceiptId(),
                    $item->getName(),
                    $item->getPrice(),
                    'perry'
                );
            });
        $person_2_bought_items = $boughtItemsCollection
            ->filter(function ($item) {
                return $item->getPayerName() === 'hannah';
            })
            ->map(function ($item) {
                return new BoughtItem(
                    $item->getBoughtItemId(),
                    $item->getReceiptId(),
                    $item->getName(),
                    $item->getPrice(),
                    'hannah'
                );
            });
        $both_bought_items = $boughtItemsCollection
            ->filter(function ($item) {
                return $item->getPayerName() === 'both';
            })
            ->map(function ($item) {
                return new BoughtItem(
                    $item->getBoughtItemId(),
                    $item->getReceiptId(),
                    $item->getName(),
                    $item->getPrice(),
                    'both'
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
    public function storeNewReceiptInfoToDatabse(
        string $title,
        string $userWhoPaid,
        int $totalAmount,
        int $person_1_amount,
        int $person_2_amount,
        array $bought_items,
        int $total_amount,
        UploadedFile $imageFile
    ): void
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
    }
    // Question: Type needed for parameter. Would it be better if this were to return a DTO instead of a plain array?
    public function getInfoFromReceiptImage(UploadedFile $imageFile)
    {
        // TODO: This $receipt_info is dummy data. Open AI API will be set here
        $receipt_info = [
        "items" => [
            [ "name" => "ハーゲンミニCロウチャクリキーウカ", "price_total" => 218 ],
            [ "name" => "オリジナルスフラッドオレンジ", "price_total" => 204 ],
            [ "name" => "オカメ スコイサットS-903", "price_total" => 264 ],
            [ "name" => "アタックウオシEXヘヤカカ850g", "price_total" => 308 ],
            [ "name" => "コウサンウオトンジヤ玉150×3", "price_total" => 78 ],
            [ "name" => "セブンスターリサンゴールド", "price_total" => 499 ],
            [ "name" => "ワイドハイターEXパワー820ml", "price_total" => 328 ],
            [ "name" => "サラヤ テイユコット100ムコち56", "price_total" => 280 ],
            [ "name" => "バナナ", "price_total" => 256 ],
            [ "name" => "ハウスバイング35g", "price_total" => 100 ],
            [ "name" => "トマト コツコ", "price_total" => 398 ],
            [ "name" => "タンノンビオカセイタクブドウ", "price_total" => 326 ],
            [ "name" => "タンノンビオ シチリアレモン 4コ", "price_total" => 163 ],
            [ "name" => "コイワイヨーグルトホンボウ400g", "price_total" => 199 ],
            [ "name" => "ミヤマ イチオシムキチ 200g", "price_total" => 153 ],
            [ "name" => "コウサンウオカトリムネニク", "price_total" => 596 ],
        ],
        "receipt_total" => 4626
        ];

        return $receipt_info;
    }
}
