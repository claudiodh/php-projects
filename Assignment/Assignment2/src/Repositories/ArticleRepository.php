<?php

namespace src\Repositories;

require_once 'Repository.php';
require_once __DIR__ . '/../Models/Article.php';

use PDOException;
use src\Models\Article as Article;
use src\Models\User;
use PDO;

class ArticleRepository extends Repository
{
    /**
     * @return Article[]
     */
    public function getArticles(string $search = '', int $limit = 0, int $offset = 0): array
    {
        try {
            $sql = "SELECT articles.*, users.name AS author_name, users.profile_picture, articles.created_at 
                FROM articles 
                JOIN users ON articles.author_id = users.id";


            if ($search !== '') {
                $sql .= " WHERE articles.title LIKE :search";
            }

            $sql .= " ORDER BY articles.created_at DESC";


            if ($limit > 0) {
                $sql .= " LIMIT :limit OFFSET :offset";
            }

            $stmt = $this->pdo->prepare($sql);

            if ($search !== '') {
                $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
            }
            if ($limit > 0) {
                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        }
    }

    public function saveArticle(string $title, string $url, int $authorId): bool
    {
        try {
            $sql = "INSERT INTO articles (title, url, author_id, created_at, updated_at) 
                VALUES (:title, :url, :author_id, NOW(), NOW())";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':url', $url);
            $stmt->bindParam(':author_id', $authorId);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error saving article: " . $e->getMessage());
            return false;
        }
    }

    public function getArticleById(int $id): ?Article
    {
        $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $article = new Article();
            $article->fill($data);
            return $article;
        }
        return null;
    }


    public function updateArticle(int $id, string $title, string $url): bool
    {
        $sql = "UPDATE articles SET title = ?, url = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$title, $url, $id]);
    }

    public function deleteArticleById(int $articleId): bool
    {
        try {
            error_log("Attempting to delete article with ID: " . $articleId);
            $sql = "DELETE FROM articles WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$articleId]);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function getArticleAuthor(string $articleId): ?User
    {
        $sqlStatement = $this->pdo->prepare("SELECT users.id, users.name, users.email, users.password, users.profile_picture FROM users INNER JOIN articles a ON users.id = a.author_id WHERE a.id = ?;");
        $success = $sqlStatement->execute([$articleId]);
        if ($success && $sqlStatement->rowCount() !== 0) {
            return (new User())->fill($sqlStatement->fetch());
        } else {
            return null;
        }
    }

    /**
     * This will be helpful for pagination.
     */
    public function getCount(string $search): int
    {
        $sqlStatement = $this->pdo->prepare("SELECT COUNT(*) FROM articles WHERE title LIKE ?;");
        $sqlStatement->execute(["%$search%"]);
        return $sqlStatement->fetchColumn() ?? 0;
    }


}

