<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserInfo extends Authenticatable
{
    use Notifiable;
    protected $table = 'user_info';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_name',
        'password',
        'profile_image_url',
        'fcm_token'
    ];

    // 👇 tell Laravel to use user_name instead of email
    public function getAuthIdentifierName()
    {
        return 'user_name';
    }
}
