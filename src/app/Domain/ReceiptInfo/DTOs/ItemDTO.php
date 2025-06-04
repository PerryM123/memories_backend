<?php

namespace App\Domain\ReceiptInfo\DTOs;


class OpenAiChoiceDTO implements \JsonSerializable
{
    public string $name;
    public int $price_total;
  
    public function __construct(string $name, int $price_total)
    {
        $this->name = $name;
        $this->price_total = $price_total;
    }
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'price_total' => $this->price_total
        ];
    }
}
