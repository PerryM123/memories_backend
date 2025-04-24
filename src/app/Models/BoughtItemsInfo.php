<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
