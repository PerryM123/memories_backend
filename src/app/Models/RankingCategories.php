<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankingCategories extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $primaryKey = 'ranking_categories_id';
    protected $table = 'ranking_categories';
    protected $fillable = [
        'ranking_categories_id',
        'rank_title'
    ];
}
