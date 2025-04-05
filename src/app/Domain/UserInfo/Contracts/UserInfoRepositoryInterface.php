<?php

// QUESTIOIN: Do I always have to manage the namespace myself everyttime I move a file around? There's no way to auto-generate this?
namespace App\Domain\UserInfo\Contracts;

use App\Domain\UserInfo\Contracts;
use App\Domain\UserInfo\Entities\User;

interface UserInfoRepositoryInterface
{
    // Question: Why don't I have to import the User class here?
    public function findById($id): ?User;
    public function save(User $user): void;
}
