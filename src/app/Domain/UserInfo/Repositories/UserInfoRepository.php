<?php
namespace App\Domain\UserInfo\Repositories;

use App\Domain\UserInfo\Contracts\UserInfoRepositoryInterface;
use App\Domain\UserInfo\Entities\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Log;

class UserInfoRepository implements UserInfoRepositoryInterface
{
  public function findById($id): ?User
  {
    $user = UserInfo::find($id);
    if (!$user) return null;
    return new User(
      $user->user_id,
      $user->user_name,
      $user->profile_image_url,
      $user->fcm_token
    );
  }
  public function save(User $order): void
  {
    // TODO
  }
}
