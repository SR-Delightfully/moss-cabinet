<?php
declare(strict_types = 1);

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
class CategoriesModel extends BaseModel {
    public function __construct (PDOService $pdo) {
        parent ::__construct($pdo); //pass it to the parent class
    }


//fetches the list of categories


    public function getCategories (): mixed {
        // {$sql = "SELECT * FROM products";
        //     $products = $this->selectAll($sql);


        //  $sql = "SELECT * FROM {$this->categories}";
        $sql = "SELECT * FROM categories";

        $categories = $this -> selectAll($sql);
        return $categories;

    }

    public function getAllCategoriesWithProducts (): array {
        $sql = "
            SELECT
                c.category_id,
                c.category_name,
                c.category_description,

                p.product_id,
                p.product_name,
                p.product_price,

                img.image_file_path AS primary_image

            FROM categories c
            LEFT JOIN products p 
                ON p.category_id = c.category_id

            LEFT JOIN product_images img 
                ON img.product_id = p.product_id
                AND img.is_primary = 1

            ORDER BY c.category_id, p.product_id
        ";

        $rows = $this -> selectAll($sql);

        if (!$rows) {
            return [];
        }

        $categories = [];

        foreach ($rows as $row) {

            $cid = $row['category_id'];

            if (!isset($categories[$cid])) {
                $categories[$cid] = [
                    'category_id' => $row['category_id'],
                    'category_name' => $row['category_name'],
                    'category_description' => $row['category_description'] ?? '',
                    'products' => []
                ];
            }

            if (!empty($row['product_id'])) {
                $categories[$cid]['products'][] = [
                    'product_id' => $row['product_id'],
                    'product_name' => $row['product_name'],
                    'product_price' => $row['product_price'],
                    'primary_image' => $row['primary_image'] ?: 'images/default.jpg'
                ];
            }
        }

        return array_values($categories);
    }


    public function searchFilteredCategories (string $query): mixed {
        $sql = "
           SELECT
                c.category_id,
                c.category_name,
                c.category_description,
                p.product_id,
                p.product_name,
                p.product_price,
                img.image_file_path AS primary_image
            FROM categories c
                LEFT JOIN products p 
                    ON p.category_id = c.category_id
                LEFT JOIN product_images img 
                    ON img.product_id = p.product_id
                    AND img.is_primary = 1
            WHERE 
                LOWER(c.category_name) LIKE ? 
                OR 
                (p.product_id IS NOT NULL AND LOWER(p.product_name) LIKE ?)
            ORDER BY c.category_id, p.product_id
        ";

        $search = '%' . strtolower($query) . '%';
        $rows = $this -> selectAll($sql, [$search, $search]);

        if (!$rows) {
            return [];
        }

        $categories = [];

        foreach ($rows as $row) {

            $cid = $row['category_id'];

            if (!isset($categories[$cid])) {
                $categories[$cid] = [
                    'category_id' => $row['category_id'],
                    'category_name' => $row['category_name'],
                    'category_description' => $row['category_description'] ?? '',
                    'products' => []
                ];
            }

            if (!empty($row['product_id'])) {
                $categories[$cid]['products'][] = [
                    'product_id' => $row['product_id'],
                    'product_name' => $row['product_name'],
                    'product_price' => $row['product_price'],
                    'primary_image' => $row['primary_image'] ?: 'images/default.jpg'
                ];
            }
        }

        return array_values($categories);
    }

}



