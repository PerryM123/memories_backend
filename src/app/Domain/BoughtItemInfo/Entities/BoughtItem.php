<?php

namespace App\Domain\BoughtItemInfo\Entities;

class BoughtItem implements \JsonSerializable
{
    private int $bought_item_id;
    private int $receipt_id;
    private string $name;
    private int $price;
    private string $payer_name;

    public function __construct(
        int $bought_item_id,
        int $receipt_id,
        string $name,
        int $price,
        string $payer_name
    ) {
        $this->bought_item_id = $bought_item_id;
        $this->receipt_id = $receipt_id;
        $this->name = $name;
        $this->price = $price;
        $this->payer_name = $payer_name;
    }

    public function getBoughtItemId(): int
    {
        return $this->bought_item_id;
    }

    public function getReceiptId(): int
    {
        return $this->receipt_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getPayerName(): string
    {
        return $this->payer_name;
    }

    public function jsonSerialize(): array
    {
        return [
            'bought_item_id' => $this->bought_item_id,
            'receipt_id' => $this->receipt_id,
            'name' => $this->name,
            'price' => $this->price,
            'payer_name' => $this->payer_name
        ];
    }
} 