<?php

namespace App\Domain\ReceiptInfo\DTOs;


class AnalyzedReceiptDTO implements \JsonSerializable
{
    private array $items;
    private int $receipt_total;

    public function __construct(array $items, int $receipt_total)
    {
        $this->items = $items;
        $this->receipt_total = $receipt_total;
    }
    public function jsonSerialize(): array
    {
        return [
            'items' => $this->items,
            'receipt_total' => $this->receipt_total
        ];
    }
}
