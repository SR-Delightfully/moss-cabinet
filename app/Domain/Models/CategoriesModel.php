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

    public function getCategories(): array
    {
        $sql = "SELECT * FROM categories";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll(): array
    {
        $sql = "
            SELECT category_id, category_name, category_description
            FROM categories
            ORDER BY category_name
        ";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllWithSubcategories(): array
    {
        $sql = "
            SELECT
                c.category_id,
                c.category_name,
                s.subcategory_id,
                s.subcategory_name
            FROM categories c
            LEFT JOIN subcategories s ON s.category_id = c.category_id
            ORDER BY c.category_name, s.subcategory_name
        ";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
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

    public function getById(int $categoryId): ?array
    {
        $sql = "
            SELECT category_id, category_name, category_description
            FROM categories
            WHERE category_id = :category_id
            LIMIT 1
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['category_id' => $categoryId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function getOneWithSubcategories(int $categoryId): array
    {
        $sql = "
            SELECT
                c.category_id,
                c.category_name,
                c.category_description,
                s.subcategory_id,
                s.subcategory_name
            FROM categories c
            LEFT JOIN subcategories s ON s.category_id = c.category_id
            WHERE c.category_id = :category_id
            ORDER BY s.subcategory_name
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['category_id' => $categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWithProductCounts(): array
    {
        $sql = "
            SELECT
                c.category_id,
                c.category_name,
                COUNT(p.product_id) AS product_count
            FROM categories c
            LEFT JOIN products p ON p.category_id = c.category_id
            GROUP BY c.category_id
            ORDER BY product_count DESC
        ";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(string $name, ?string $description = null): bool
    {
        $sql = "
            INSERT INTO categories (category_name, category_description)
            VALUES (:name, :description)
        ";
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
}
