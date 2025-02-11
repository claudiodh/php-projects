<?php

namespace src\Repositories;

require_once __DIR__ . '/Repository.php';

require_once __DIR__ . '/../Models/Post.php';
require_once __DIR__ . '/../Logger/Log.php';

use src\Logger\Log;
use src\Models\Post as Post;
use PDO;
use PDOException;


class PostRepository extends Repository
{
    /**
     * @return Post[]
     */
    public function getAllPosts(): array
    {
        try {
            $sqlStatement = $this->pdo->query("SELECT * FROM posts;");
            $rows = $sqlStatement->fetchAll();

            $posts = [];
            foreach ($rows as $row) {
                $posts[] = (new Post())->fill($row);
            }

            return $posts;
        } catch (PDOException $e) {
            Log::error("Database Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * This is a poorly implemented function for a few reasons:
     * 1. Vulnerable to SQL injection
     * 2. No exception handling
     * You'll need to fix it.
     */
    public function save(Post $post): void
    {
        try {
            $createdAt = date('Y-m-d H:i:s');

            $sqlStatement = $this->pdo->prepare(
                "INSERT INTO posts (created_at, updated_at, body, title) VALUES (:created_at, NULL, :body, :title)"
            );

            $sqlStatement->execute([
                ':created_at' => $createdAt,
                ':body' => $post->getBody(),
                ':title' => $post->getTitle()
            ]);

            $post->setId($this->pdo->lastInsertId());
        } catch (PDOException $e) {
            Log::error("Failed to save post: " . $e->getMessage());
        }
    }

    public function findById(int $id): ?Post
    {
        try {
            $sqlStatement = $this->pdo->prepare('SELECT * FROM posts WHERE id = :id');
            $sqlStatement->execute([':id' => $id]);
            $resultSet = $sqlStatement->fetch();

            return $resultSet ? (new Post())->fill($resultSet) : null;
        } catch (PDOException $e) {
            Log::error("Database Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * @return bool true on success, false otherwise
     */
    public function update(Post $post): bool
    {
        try {
            $updatedAt = date('Y-m-d H:i:s');
            $sqlStatement = $this->pdo->prepare(
                "UPDATE posts SET title = :title, body = :body, updated_at = :updated_at WHERE id = :id"
            );
            return $sqlStatement->execute([
                ':title' => $post->getTitle(),
                ':body' => $post->getBody(),
                ':updated_at' => $updatedAt,
                ':id' => $post->getId()
            ]);
        } catch (PDOException $e) {
            Log::error("Failed to update post: " . $e->getMessage());
            return false;
        }
    }

    /**
     * @return bool true on success, false otherwise
     */
    public function delete(Post $post): bool
    {
        try {
            $sqlStatement = $this->pdo->prepare("DELETE FROM posts WHERE id = :id");
            return $sqlStatement->execute([':id' => $post->getId()]);
        } catch (PDOException $e) {
            Log::error("Failed to delete post: " . $e->getMessage());
            return false;
        }
    }
}
