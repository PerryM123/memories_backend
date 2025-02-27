<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostInfo extends Model
{
    use HasFactory;
    protected $table = 'post_info';
    protected $primaryKey = 'post_info_id';
    protected $fillable = [
        'post_info_id',
        'user_id',
        'message_title',
        'message_text',
        'post_date',
        'frame_type',
        'is_edited',
        'is_deleted'
    ];
}
