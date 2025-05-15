<?php

namespace App\Domain\ReceiptInfo\DTOs;

use Illuminate\Support\Collection;

class PaginatedReceiptsDTO implements \JsonSerializable
{
    public function __construct(
        private Collection $data,
        private int $total
    ) {}
    public function jsonSerialize(): array
    {
        return [
            'data' => $this->data,
            'total' => $this->total,
        ];
    }
}