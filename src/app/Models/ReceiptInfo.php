<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
