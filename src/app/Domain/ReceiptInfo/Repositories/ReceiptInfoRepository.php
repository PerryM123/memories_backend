<?php

namespace App\Domain\ReceiptInfo\Repositories;

use App\Domain\ReceiptInfo\Contracts\ReceiptInfoRepositoryInterface;
use App\Domain\ReceiptInfo\Entities\Receipt;
use App\Models\ReceiptInfo;
use Illuminate\Support\Facades\Log;

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
  // QUESTION: array<ReceiptInfo> doesn't work in php?
  public function findAllReceipts(): ?array
  {
    $receipt = ReceiptInfo::all();
    Log::info('[LOG] ReceiptInfoRepository', ['$receipt' => $receipt]);
    if (!$receipt) return [];
    // TODO: Should I convert it to an array? Or just return the collection object??
    return [];
  }
  public function save(Receipt $order): void
  {
    // TODO
  }
}
