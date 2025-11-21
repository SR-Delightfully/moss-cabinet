<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;
use PDO;

class UserModel extends BaseModel
{
    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }

    /**
     * Create a new user record in the database.
     *
     * @param array $data
     * @return int  The ID of the newly created user.
     */
    public function createUser(array $data): int
    {
        // Hash password
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $sql = "
            INSERT INTO users 
            (user_username, user_first_name, user_last_name, user_email, user_password_hashed) 
            VALUES 
            (:username, :first_name, :last_name, :email, :password)
        ";

        $params = [
            ':username'   => $data['username'],
            ':first_name' => $data['first_name'],
            ':last_name'  => $data['last_name'],
            ':email'      => $data['email'],
            ':password'   => $hashedPassword,
        ];

        // Use BaseModel::execute()
        $this->execute($sql, $params);

        // Return last inserted ID
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Find a user by email.
     *
     * @param string $email
     * @return array|null
     */
    public function findByEmail(string $email): ?array
    {
        $sql = "
            SELECT * 
            FROM users 
            WHERE user_email = :email
            LIMIT 1
        ";

        $result = $this->selectOne($sql, [':email' => $email]);
        return $result ?: null;
    }

    /**
     * Find a user by username.
     *
     * @param string $username
     * @return array|null
     */
    public function findByUsername(string $username): ?array
    {
        $sql = "
            SELECT * 
            FROM users 
            WHERE user_username = :username
            LIMIT 1
        ";

        $result = $this->selectOne($sql, [':username' => $username]);
        return $result ?: null;
    }

    /**
     * Fetch all users.
     *
     * @return array
     */
    public function getUsers(): array
    {
        $sql = "SELECT * FROM users";
        return $this->selectAll($sql);
    }
}
