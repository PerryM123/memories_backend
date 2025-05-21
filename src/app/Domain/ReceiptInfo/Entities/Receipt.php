<?php

namespace App\Domain\ReceiptInfo\Entities;

use Illuminate\Support\Collection;

class Receipt implements \JsonSerializable
{
    private int $receipt_id;
    private string $title;
    private string $image_url;
    private string $user_who_paid;
    private int $total_amount;
    private int $person_1_amount;
    private int $person_2_amount;
    private Collection $bought_items;

    // QUESTION: Should this be an object to be passed in so that we can type/dependency inject it? Or no?
    public function __construct(
        int $receipt_id,
        string $title,
        string $image_url,
        string $user_who_paid,
        string $total_amount,
        string $person_1_amount,
        string $person_2_amount,
        Collection $bought_items
    ) {
        $this->receipt_id = $receipt_id;
        $this->title = $title;
        $this->image_url = $image_url;
        $this->user_who_paid = $user_who_paid;
        $this->total_amount = $total_amount;
        $this->person_1_amount = $person_1_amount;
        $this->person_2_amount = $person_2_amount;
        $this->bought_items = $bought_items ?? new Collection();
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
    public function getPersonOneAmount(): string
    {
        return $this->person_1_amount;
    }
    public function getPersonTwoAmount(): string
    {
        return $this->person_2_amount;
    }
    public function getBoughtItems(): Collection
    {
        return $this->bought_items;
    }
    public function jsonSerialize(): array
    {
        return [
            'receipt_id' => $this->receipt_id,
            'title' => $this->title,
            'image_url' => $this->image_url,
            'user_who_paid' => $this->user_who_paid,
            'total_amount' => $this->total_amount,
            'person_1_amount' => $this->person_1_amount,
            'person_2_amount' => $this->person_2_amount,
            'bought_items' => $this->bought_items->toArray()
        ];
    }
}
