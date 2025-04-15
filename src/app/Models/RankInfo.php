<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RankInfo extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'rank_info';
    protected $fillable = [
        'id',
        'ranking_categories_id',
        'rank_number',
        'title',
        'image_url',
    ];
}
