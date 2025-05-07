<?php

namespace App\Domain\ReceiptInfo\Repositories;

use App\Domain\ReceiptInfo\Contracts\ReceiptInfoRepositoryInterface;
use App\Domain\ReceiptInfo\Entities\Receipt;
use App\Models\ReceiptInfo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ReceiptInfoRepository implements ReceiptInfoRepositoryInterface
{
  public function findById($id): ?Receipt
  {
    $receipt = ReceiptInfo::find($id);
    if (!$receipt) return null;
    return new Receipt(
      $receipt->receipt_id,
      $receipt->title,
      $receipt->image_url,
      $receipt->user_who_paid,
      $receipt->total_amount
    );
  }
  /**
   * @return Collection<int, ReceiptInfo>
   */
  public function findAllReceipts(): Collection
  {
    $receipt = ReceiptInfo::all();
    return $receipt;
  }
  public function storeNewReceiptInfoToDatabse(
    string $title,
    string $userWhoPaid,
    int $totalAmount,
    UploadedFile $imageFile
  ): void
  {
    try {
        $filename = uniqid() . '.' . $imageFile->getClientOriginalExtension();
        $path = Storage::disk('s3')->putFileAs('uploads/images', $imageFile, $filename);
        $imageUrl = Storage::disk('s3')->url($path);
        $receipt_info = ReceiptInfo::create([
          'title' => $title,
          'image_url' => $imageUrl,
          'user_who_paid' => $userWhoPaid,
          'total_amount' => $totalAmount
        ]);
        Log::info('Receipt Info was successfully uploaded to s3', ['$receipt_info' => $receipt_info]);
    } catch (\Exception $e) {
        $errorMessage = 'Failed to upload receipt info to s3';
        Log::error($errorMessage, [
            'error' => $e->getMessage(),
            'file' => $imageFile->getClientOriginalName()
        ]);
        throw new \RuntimeException($errorMessage . ': ' . $e->getMessage());
    }
  }
  // Question: Type needed for parameter. Would it be better if this were to return a DTO instead of a plain array?
  public function getReceiptInfoFromReceiptImage(UploadedFile $imageFile)
  {
    Log::info('getReceiptInfoFromReceiptImage:', ['image' => $imageFile]);
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
