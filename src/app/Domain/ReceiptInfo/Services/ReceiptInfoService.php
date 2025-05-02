<?php

namespace App\Domain\ReceiptInfo\Services;

use App\Domain\ReceiptInfo\Contracts\ReceiptInfoRepositoryInterface;
use App\Domain\ReceiptInfo\Entities\Receipt;

class ReceiptInfoService
{
  private ReceiptInfoRepositoryInterface $ReceiptInfoRepository;

  public function __construct(ReceiptInfoRepositoryInterface $ReceiptInfoRepository)
  {
    $this->ReceiptInfoRepository = $ReceiptInfoRepository;
  }

  public function getReceiptById(int $id): ?Receipt
  {
    return $this->ReceiptInfoRepository->findById($id);
  }

  public function getAllReceipts(): ?array
  {
    return $this->ReceiptInfoRepository->findAllReceipts();
  }

  // TODO
  public function createReceipt(
    int $user_id,
    string $user_name,
    string $password,
    string $profile_image_url,
    string $fcm_token,
  ): Receipt {
    $receipt = new Receipt(
      $user_id,
      $user_name,
      $password,
      $profile_image_url,
      $fcm_token
    );
    $this->ReceiptInfoRepository->save($receipt);
    return $receipt;
  }
}
