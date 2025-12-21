<?php

declare(strict_types=1);

namespace App\Domain\Models;

use PDO;

class SubcategoryModel extends BaseModel
{
    protected string $table = 'subcategories';
    protected string $primaryKey = 'subcategory_id';

    public function getAllWithCategories(): array
    {
        $sql = "
            SELECT
                s.subcategory_id,
                s.subcategory_name,
                c.category_id,
                c.category_name
            FROM subcategories s
            JOIN categories c
              ON s.category_id = c.category_id
            ORDER BY c.category_name, s.subcategory_name
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByCategoryId(int $categoryId): array
    {
        $sql = "
            SELECT
                s.subcategory_id,
                s.subcategory_name
            FROM subcategories s
            WHERE s.category_id = :category_id
            ORDER BY s.subcategory_name
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['category_id' => $categoryId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWithProductCounts(int $categoryId): array
    {
        $sql = "
            SELECT
                s.subcategory_id,
                s.subcategory_name,
                COUNT(p.product_id) AS product_count
            FROM subcategories s
            LEFT JOIN products p
              ON p.subcategory_id = s.subcategory_id
            WHERE s.category_id = :category_id
            GROUP BY s.subcategory_id
            ORDER BY s.subcategory_name
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['category_id' => $categoryId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOneWithCategory(int $subcategoryId): ?array
    {
        $sql = "
            SELECT
                s.subcategory_id,
                s.subcategory_name,
                c.category_id,
                c.category_name
            FROM subcategories s
            JOIN categories c
              ON s.category_id = c.category_id
            WHERE s.subcategory_id = :subcategory_id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['subcategory_id' => $subcategoryId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    public function create(int $categoryId, string $name): bool
    {
        $sql = "
            INSERT INTO subcategories (category_id, subcategory_name)
            VALUES (:category_id, :subcategory_name)
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'category_id'     => $categoryId,
            'subcategory_name'=> $name
        ]);
    }

    public function update(int $subcategoryId, int $categoryId, string $name): bool
    {
        $sql = "
            UPDATE subcategories
            SET category_id = :category_id,
                subcategory_name = :subcategory_name
            WHERE subcategory_id = :subcategory_id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'subcategory_id'  => $subcategoryId,
            'category_id'     => $categoryId,
            'subcategory_name'=> $name
        ]);
    }

    public function delete(int $subcategoryId): bool
    {
        $sql = "DELETE FROM subcategories WHERE subcategory_id = :subcategory_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'subcategory_id' => $subcategoryId
        ]);
    }
}
