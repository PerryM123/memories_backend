<?php

namespace App\Models;

use App\Domain\BoughtItemInfo\Entities\BoughtItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReceiptInfo extends Model
{
    use HasFactory;
    protected $primaryKey = 'receipt_id';
    protected $fillable = [
        'receipt_id',
        'title',
        'image_url',
        'user_who_paid',
        'total_amount',
        'person_1_amount',
        'person_2_amount'
    ];
    public function boughtItems(): HasMany
    {
        return $this->hasMany(BoughtItem::class, 'receipt_id', 'receipt_id');
    }
} 
