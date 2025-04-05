<?php

namespace App\Domain\UserInfo\Services;

use App\Domain\UserInfo\Contracts\UserInfoRepositoryInterface;
use App\Domain\UserInfo\Entities\User;
use Illuminate\Support\Facades\Log;

class UserInfoService
{
  private UserInfoRepositoryInterface $UserInfoRepository;

  public function __construct(UserInfoRepositoryInterface $UserInfoRepository)
  {
    $this->UserInfoRepository = $UserInfoRepository;
  }

  public function getUserById(int $id): ?User
  {
    return $this->UserInfoRepository->findById($id);
  }

  public function createUser(
    int $user_id,
    string $user_name,
    string $password,
    string $profile_image_url,
    string $fcm_token,
  ): User {
    $user = new User(
      $user_id,
      $user_name,
      $password,
      $profile_image_url,
      $fcm_token
    );
    $this->UserInfoRepository->save($user);
    return $user;
  }
}
