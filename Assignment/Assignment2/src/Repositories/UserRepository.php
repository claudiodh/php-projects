<?php

namespace src\Repositories;

require_once 'Repository.php';
require_once __DIR__ . '/../Models/User.php';

use src\Models\User;
use PDOException;

class UserRepository extends Repository
{
    /**
     * Get a user by its ID.
     *
     * @param string $id
     * @return User|false
     */
    public function getById(string $id): User|false
    {
        try {
            $sqlStatement = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
            $sqlStatement->execute([$id]);
            $data = $sqlStatement->fetch();

            if ($data) {
                // Rename 'password' to 'password_digest' so the User model sees what it expects:
                $data['password_digest'] = $data['password'];
                unset($data['password']);

                return (new User())->fill($data);
            }

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Get a user by its email.
     *
     * @param string $email
     * @return User|null
     */
    public function getByEmail(string $email): ?User
    {
        try {
            $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$email]);
            $data = $stmt->fetch();

            error_log("Query executed for email: " . $email);
            error_log("Result: " . print_r($data, true));

            if ($data) {
                $data['password_digest'] = $data['password'];
                unset($data['password']);

                return (new User())->fill($data);
            }

            return null;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Save a new user to the database.
     *
     * @param string $name
     * @param string $email
     * @param string $passwordDigest
     * @return User|false
     */
    public function saveUser(string $name, string $email, string $passwordDigest): User|false
    {
        try {
            //  DB column is 'password', but we have $passwordDigest in the code.
            $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);

            if ($stmt->execute([$name, $email, $passwordDigest])) {
                $id = $this->pdo->lastInsertId();

                $user = new User();

                // Map 'password_digest' for fill(), but the DB column is 'password'
                $user->fill([
                    'id'              => $id,
                    'name'            => $name,
                    'email'           => $email,
                    'password_digest' => $passwordDigest, // The model needs this key
                ]);

                return $user;
            }

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Update an existing user's information.
     *
     * @param int $id
     * @param string $name
     * @param string|null $profilePicture
     * @return bool
     */
    public function updateUser(int $id, string $name, ?string $profilePicture = null): bool
    {
        try {
            if ($profilePicture !== null) {
                $sql = "UPDATE users SET name = ?, profile_picture = ? WHERE id = ?";
                $stmt = $this->pdo->prepare($sql);
                return $stmt->execute([$name, $profilePicture, $id]);
            } else {
                $sql = "UPDATE users SET name = ? WHERE id = ?";
                $stmt = $this->pdo->prepare($sql);
                return $stmt->execute([$name, $id]);
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Validate registration input.
     *
     * @param array $data
     * @return array Errors found (empty if valid)
     */
    public function validateRegistration(array $data): array
    {
        $errors = [];

        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            $errors[] = "Please fill in all fields.";
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address.";
        }

        if (strlen($data['password']) < 8 || !preg_match('/[\\W]/', $data['password'])) {
            $errors[] = "Password must be at least 8 characters long and contain at least one symbol.";
        }

        return $errors;
    }
}