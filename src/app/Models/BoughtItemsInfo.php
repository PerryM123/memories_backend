<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoughtItemsInfo extends Model
{
    use HasFactory;
    protected $primaryKey = 'bought_item_id';
    protected $fillable = [
        'bought_item_id',
        'receipt_id',
        'name',
        'price',
        'payer_name'
    ];
    public function receiptInfo(): BelongsTo
    {
        return $this->belongsTo(ReceiptInfo::class, 'receipt_id', 'receipt_id');
    }
}
