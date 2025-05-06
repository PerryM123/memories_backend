<?php

namespace App\Domain\ReceiptInfo\Contracts;

use App\Domain\ReceiptInfo\Entities\Receipt;

interface ReceiptInfoRepositoryInterface
{
    public function findById($id): ?Receipt;
    public function findAllReceipts(): ?array;
    // TODO: Is it better to make this: saveReceiptInfo?
    public function save(Receipt $receipt): void;
}
