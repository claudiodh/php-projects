<?php

namespace src\Repositories;

require_once __DIR__ . '/../Logger/Log.php';

use PDO;
use PDOException;
use src\Logger\Log as Log;

/**
 * An example of a base class to reduce database connectivity configuration for each repository subclass.
 */
class Repository
{
    protected PDO $pdo;
    private string $hostname;
    private string $username;
    private string $databaseName;
    private string $databasePassword;
    private string $charset;
    private string $port;

    public function __construct()
    {
        // Note: in a real application we'd want to use environment variables to store credentials and any other environment specific data.
        // If you're interested in how to do this, look into: https://github.com/vlucas/phpdotenv
        // If you know about PHP frameworks, DotEnv is what Laravel uses for this purpose
        // We will do this as part of a later lab in the course (not required for lab 4).
        $this->hostname = 'localhost';
        $this->username = 'root';
        $this->databaseName = 'posts_web_app';
        $this->databasePassword = 'totodile';
        $this->charset = 'utf8mb4';
        $this->port = '3306';

        $dsn = "mysql:host=$this->hostname;port=$this->port;dbname=$this->databaseName;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->databasePassword, $options);
        } catch (PDOException $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
    // Method to get the PDO connection (optional but useful)
    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
