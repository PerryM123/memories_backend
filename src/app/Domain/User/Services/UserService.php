<?php

namespace App\Domain\User\Services;

use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserRepositoryInterface;

class UserService
{
  private UserRepositoryInterface $userRepository;

  public function __construct(UserRepositoryInterface $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function getUserById(int $id): ?User
  {
    return $this->userRepository->findById($id);
  }

  public function createUser(
    int $user_id,
    string $user_name,
    string $password,
    string $profile_image_url,
    string $fcm_token,
  ): User {
    // TODO: validation必須
    $user = new User(
      $user_id,
      $user_name,
      $password,
      $profile_image_url,
      $fcm_token,
    );
    $this->userRepository->save($user);
    return $user;
  }
}
