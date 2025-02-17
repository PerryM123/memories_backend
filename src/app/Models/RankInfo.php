<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RankInfo extends Model
{
    // TODO: 逆にtimestampsあった方がいい？？？
    public $timestamps = false;
    use HasFactory;
    protected $table = 'rank_info';
    protected $fillable = [
        'id',
        'ranking_categories_id',
        'rank_number',
        'title',
        // TODO: Is it possible to add a prettier to php laravel files so that trailing commas won't be allowed????
        'image_url',
    ];
}
