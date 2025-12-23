<?php
declare(strict_types=1);

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;
use PDO;

class CategoriesModel extends BaseModel
{
    protected string $table = 'categories';
    protected string $primaryKey = 'category_id';

    public function __construct(PDOService $pdoService)
    {
        parent::__construct($pdoService);
    }

    public function getAllCategoriesWithProducts(): array
    {
        $sql = "
            SELECT
                c.category_id,
                c.category_name,
                p.product_id,
                p.product_name
            FROM categories c
            LEFT JOIN products p ON p.category_id = c.category_id
            ORDER BY c.category_name, p.product_name
        ";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(string $name, ?string $description = null): bool
    {
        $sql = "INSERT INTO categories (category_name, category_description) VALUES (:name, :description)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'name' => $name,
            'description' => $description
        ]);
    }

    public function update(int $categoryId, string $name, ?string $description = null): bool
    {
        $sql = "
            UPDATE categories
            SET category_name = :name,
                category_description = :description
            WHERE category_id = :category_id
        ";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'category_id' => $categoryId,
            'name' => $name,
            'description' => $description
        ]);
    }

    public function delete(int $categoryId): bool
    {
        $sql = "DELETE FROM categories WHERE category_id = :category_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['category_id' => $categoryId]);
    }

    public function getById(int $categoryId): ?array
    {
        $sql = "SELECT category_id, category_name, category_description FROM categories WHERE category_id = :category_id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['category_id' => $categoryId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
}
