<?php
// QUESTION: What is the use case for namespace? For autocompletion?
namespace App\Domain\User\Repositories;

use App\Domain\User\Contracts\UserRepositoryInterface;
use App\Domain\User\Entities\User;

class UserRepository implements UserRepositoryInterface
{
  public function findById($id): User
  {
    // TODO: Below is dummy data. Use Eloquent to find the user by ID.
    return new User(
      "1",
      "Perry",
      "password",
      "https://example.com/image.jpg",
      "random_fcm_token_here"
    );
  }
  public function save(User $order): void
  {
    // TODO: Below is dummy data. Use Eloquent to find the user by ID.
  }
}
