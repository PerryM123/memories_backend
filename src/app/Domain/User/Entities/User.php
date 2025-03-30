<?php

namespace App\Domain\User\Entities;

class User
{
    private int $user_id;
    private string $user_name;
    private string $password;
    private string $profile_image_url;
    private string $fcm_token;

    // QUESTION: Should this be an object to be passed in so that we can type/dependency inject it? Or no?
    public function __construct(
        int $user_id,
        string $user_name,
        string $password,
        string $profile_image_url,
        string $fcm_token
    ) {
        $this->$user_id = $user_id;
        $this->$user_name = $user_name;
        $this->$password = $password;
        $this->$profile_image_url = $profile_image_url;
        $this->$fcm_token = $fcm_token;
    }
    public function getUserId(): int
    {
        return $this->user_id;
    }
    public function getUserName(): string
    {
        return $this->user_name;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getProfileImageUrl(): string
    {
        return $this->profile_image_url;
    }
    public function getFcmToken(): string
    {
        return $this->fcm_token;
    }
}
