<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;
    protected $table = 'user_info';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_name',
        'password',
        'profile_image_url',
        'fcm_token'
    ];
}
