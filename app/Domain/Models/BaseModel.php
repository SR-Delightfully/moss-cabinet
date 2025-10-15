<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;
use PDO;

/**
 * Base model class for all models.
 *
 * This class provides a base implementation for all models with PDO wrapper methods.
 * It is intended to be extended by specific model classes.
 *
 * @example
 * class UserModel extends BaseModel {
 *     public function findById(int $id): array|false {
 *         return $this->selectOne('SELECT * FROM users WHERE id = ?', [$id]);
 *     }
 * }
 */
class BaseModel
{
    protected PDO $pdo;

    public function __construct(PDOService $db_service)
    {
        $this->pdo = $db_service->getPDO();
    }

    /**
     * Execute a SELECT query and return all results.
     *
     * @param string $sql The SQL query to execute
     * @param array $params Optional parameters for prepared statement
     * @return array Array of all matching records
     */
    protected function selectAll(string $sql, array $params = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Execute a SELECT query and return a single result.
     *
     * @param string $sql The SQL query to execute
     * @param array $params Optional parameters for prepared statement
     * @return array|false Single record as array, or false if not found
     */
    protected function selectOne(string $sql, array $params = []): array|false
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    /**
     * Execute a COUNT query and return the count result.
     *
     * @param string $sql The COUNT SQL query to execute
     * @param array $params Optional parameters for prepared statement
     * @return int The count result as integer
     */
    protected function count(string $sql, array $params = []): int
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    /**
     * Execute an INSERT, UPDATE, or DELETE query.
     *
     * @param string $sql The SQL query to execute
     * @param array $params Optional parameters for prepared statement
     * @return int Number of affected rows
     */
    protected function execute(string $sql, array $params = []): int
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    /**
     * Get the last inserted ID.
     *
     * @param string|null $name Optional sequence name for PostgreSQL
     * @return string The last inserted ID
     */
    protected function lastInsertId(?string $name = null): string
    {
        return $this->pdo->lastInsertId($name);
    }

    /**
     * Begin a database transaction.
     *
     * @return bool True on success, false on failure
     */
    protected function beginTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }

    /**
     * Commit the current transaction.
     *
     * @return bool True on success, false on failure
     */
    protected function commit(): bool
    {
        return $this->pdo->commit();
    }

    /**
     * Rollback the current transaction.
     *
     * @return bool True on success, false on failure
     */
    protected function rollback(): bool
    {
        return $this->pdo->rollback();
    }
}
