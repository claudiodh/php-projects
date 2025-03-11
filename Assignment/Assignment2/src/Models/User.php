<?php

namespace src\Models;

require_once 'Model.php';

class User extends Model
{
    private string $email;
    private string $name;
    private string $password_digest;
    private string $profile_picture;

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPasswordDigest(): string
    {
        return $this->password_digest;
    }

    public function setPasswordDigest(string $passwordDigest): void
    {
        $this->password_digest = $passwordDigest;
    }

    public function setProfilePicture(string $profilePicture): void
    {
        $this->profile_picture = $profilePicture;
    }

    public function getProfilePicture(): string
    {
        return $this->profile_picture;
    }

    public function fill(array $attributes): self
    {
        foreach ($attributes as $attribute => $value) {
            $this->$attribute = $value;
        }

        return $this;
    }
}
