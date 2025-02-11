<?php

namespace src\Models;

abstract class Model
{
    protected ?int $id;
    protected ?string $created_at;
    protected ?string $updated_at;

    public function __construct(?int $id = null, ?string $createdAt = null, ?string $updatedAt = null)
    {
        $this->setId($id);
        $this->setCreatedAt($createdAt);
        $this->setUpdatedAt($updatedAt);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setCreatedAt(?string $createdAt): void
    {
        $this->created_at = $createdAt;
    }

    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updated_at = $updatedAt;
    }

    public function getCreatedAtFmt(): ?string
    {
        if ($this->created_at) {
            return date("l jS \of F Y, h:i A", strtotime($this->created_at));
        } else {
            return null;
        }
    }

    public function getUpdatedAtFmt(): ?string
    {
        if ($this->updated_at) {
            return date("l jS \of F Y, h:i A", strtotime($this->updated_at));
        } else {
            return null;
        }
    }

    abstract public function fill(array $attributes): self;

}
