<?php

namespace App\Domain\ReceiptInfo\Contracts;

use App\Domain\ReceiptInfo\DTOs\PaginatedReceiptsDTO;
use App\Domain\ReceiptInfo\Entities\Receipt;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

interface ReceiptInfoRepositoryInterface
{
    public function findById($id): ?Receipt;
    public function findAllReceipts(): Collection;
    public function getPaginatedReceipts(int $page): PaginatedReceiptsDTO;
    public function storeNewReceiptInfoToDatabse(
        string $title,
        string $userWhoPaid,
        int $totalAmount,
        int $person_1_amount,
        int $person_2_amount,
        array $bought_items,
        int $total_amount,
        UploadedFile $imageFile
    ): void;
    // TODO: Need to figure out the type for this function which will call the OpenAI API
    // TODO: Type needed for parameter
    public function getInfoFromReceiptImage(UploadedFile $imageFile);
}
