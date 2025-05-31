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
    public function storeNewReceipt(
        string $title,
        string $userWhoPaid,
        int $totalAmount,
        int $personOneAmount,
        int $personTwoAmount,
        array $bought_items,
        int $total_amount,
        UploadedFile $imageFile
    ): ?Receipt {
        Log::info('ReceiptInfoService: storeNewReceipt:', ['image' => $imageFile]);
        return $this->ReceiptInfoRepository->storeNewReceiptInfoToDatabase(
            $title, 
            $userWhoPaid, 
            $totalAmount, 
            $personOneAmount, 
            $personTwoAmount,
            $bought_items,
            $total_amount,
            $imageFile
        );
    }

    /**
     * Sends image to Open AI to get receipt info from the image
     */
    // TODO: 実装必須
    // TODO: Need a proper return type for this function...
    public function getInfoFromReceiptImage(UploadedFile $imageFile) {
        Log::info('ReceiptInfoService: analyzeReceiptImage:', ['image' => $imageFile]);
        return $this->ReceiptInfoRepository->getInfoFromReceiptImage($imageFile);
    }
}
