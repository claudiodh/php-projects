<?php

namespace src\Models;

require_once 'Model.php';

class Post extends Model
{
    private ?string $title;
    private ?string $body;

    public function __construct(
        ?int $id = null,
        ?string $title = null,
        ?string $body = null,
        ?string $updatedAt = null,
        ?string $createdAt = null
    ) {
        parent::__construct($id, $createdAt, $updatedAt);
        $this->setTitle($title);
        $this->setBody($body);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function setBody(?string $body): void
    {
        $this->body = $body;
    }

    public function fill(array $attributes): self
    {
        foreach ($attributes as $attribute => $value) {
            $this->$attribute = $value;
        }

        return $this;
    }

}
