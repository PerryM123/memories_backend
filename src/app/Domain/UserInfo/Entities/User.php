<?php

namespace App\Domain\UserInfo\Entities;

class User implements \JsonSerializable
{
    private int $user_id;
    private string $user_name;
    private string $profile_image_url;
    private string $fcm_token;

    // QUESTION: Should this be an object to be passed in so that we can type/dependency inject it? Or no?
    public function __construct(
        int $user_id,
        string $user_name,
        string $profile_image_url,
        string $fcm_token
    ) {
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->profile_image_url = $profile_image_url;
        $this->fcm_token = $fcm_token;
    }
    public function getUserId(): int
    {
        return $this->user_id;
    }
    public function getUserName(): string
    {
        return $this->user_name;
    }
    public function getProfileImageUrl(): string
    {
        return $this->profile_image_url;
    }
    public function getFcmToken(): string
    {
        return $this->fcm_token;
    }
    public function jsonSerialize(): array
    {
        return [
            'user_id' => $this->user_id,
            'user_name' => $this->user_name,
            'profile_image_url' => $this->profile_image_url,
            'fcm_token' => $this->fcm_token,
        ];
    }
}
