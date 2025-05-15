<?php

namespace App\Domain\ReceiptInfo\Services;

use App\Domain\ReceiptInfo\Contracts\ReceiptInfoRepositoryInterface;
use App\Domain\ReceiptInfo\DTOs\PaginatedReceiptsDTO;
use App\Domain\ReceiptInfo\Entities\Receipt;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

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

    public function getAllReceipts(): Collection
    {
        return $this->ReceiptInfoRepository->findAllReceipts();
    }
    public function getPaginatedReceipts(int $page): PaginatedReceiptsDTO
    {
        Log::info('Services: getPaginatedReceipts');
        return $this->ReceiptInfoRepository->getPaginatedReceipts($page);
    }

    /**
     * Saves receipt info into database
     */
    // TODO: Need to figure out the return type for this function
    public function storeNewReceipt(
        string $title,
        string $userWhoPaid,
        int $totalAmount,
        UploadedFile $imageFile
    ) {
        $this->ReceiptInfoRepository->storeNewReceiptInfoToDatabse($title, $userWhoPaid, $totalAmount, $imageFile);
    }

    /**
     * Sends image to Open AI to get receipt info from the image
     */
    // TODO: 実装必須
    // TODO: Need a proper return type for this function...
    public function analyzeReceiptImage(UploadedFile $imageFile) {
        Log::info('analyzeReceiptImage:', ['image' => $imageFile]);
        return $this->ReceiptInfoRepository->getReceiptInfoFromReceiptImage($imageFile);
    }
}
