<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankingCategories extends Model
{
    // TODO: 逆にtimestampsあった方がいい？？？
    public $timestamps = false;
    use HasFactory;
    protected $primaryKey = 'ranking_categories_id';
    protected $table = 'ranking_categories';
    protected $fillable = [
        'ranking_categories_id',
        'rank_title'
    ];
}
