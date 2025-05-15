<?php

namespace App\Domain\ReceiptInfo\DTOs;

use Illuminate\Support\Collection;

class PaginatedReceiptsDTO implements \JsonSerializable
{
    public function __construct(
        private Collection $receipt_data,
        private int $total
    ) {}
    public function jsonSerialize(): array
    {
        return [
            'receipt_data' => $this->receipt_data,
            'total' => $this->total,
        ];
    }
}