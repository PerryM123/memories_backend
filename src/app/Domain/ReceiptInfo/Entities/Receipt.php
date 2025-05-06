<?php

namespace App\Domain\ReceiptInfo\Entities;

class Receipt implements \JsonSerializable
{
    private int $receipt_id;
    private string $title;
    private string $image_url;
    private string $user_who_paid;
    private int $total_amount;

    // QUESTION: Should this be an object to be passed in so that we can type/dependency inject it? Or no?
    public function __construct(
        int $receipt_id,
        string $title,
        string $image_url,
        string $user_who_paid,
        string $total_amount
    ) {
        $this->receipt_id = $receipt_id;
        $this->title = $title;
        $this->image_url = $image_url;
        $this->user_who_paid = $user_who_paid;
        $this->total_amount = $total_amount;
    }
    public function getReceiptId(): int
    {
        return $this->receipt_id;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function getImageUrl(): string
    {
        return $this->image_url;
    }
    public function getUserWhoPaid(): string
    {
        return $this->user_who_paid;
    }
    public function getTotalAmount(): string
    {
        return $this->total_amount;
    }
    public function jsonSerialize(): array
    {
        return [
            'receipt_id' => $this->receipt_id,
            'title' => $this->title,
            'image_url' => $this->image_url,
            'user_who_paid' => $this->user_who_paid,
            'total_amount' => $this->total_amount,
        ];
    }
}
