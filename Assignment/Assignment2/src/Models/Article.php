<?php

namespace src\Models;

require_once 'Model.php';

class Article extends Model
{
    private ?string $title;
    private ?string $url;
    private ?int $author_id;

    public function __construct(
        ?int $id = null,
        ?int $authorId = null,
        ?string $title = null,
        ?string $url = null,
        ?string $updatedAt = null,
        ?string $createdAt = null
    ) {
        parent::__construct($id, $createdAt, $updatedAt);
        $this->setTitle($title);
        $this->setUrl($url);
        $this->setAuthorId($id);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    public function setAuthorId(?int $authorId): void
    {
        $this->author_id = $authorId;
    }

    public function getAuthorId(): ?int
    {
        return $this->author_id;
    }

    public function fill(array $attributes): self
    {
        foreach ($attributes as $attribute => $value) {
            $this->$attribute = $value;
        }

        return $this;
    }

}
