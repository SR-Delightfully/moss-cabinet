<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class ProductsModel extends BaseModel {
    private string $products_table = "products";
    private string $collections_table = "collections";
    private string $categories_table = "categories";
    private string $product_images_table = "product_images";

    public function __construct (PDOService $pdoService) {
        parent ::__construct($pdoService);
    }

    public function fetchAllProducts (): array {
        $sql = "
        SELECT
            p.product_id,
            p.product_name,
            p.product_price,
            COALESCE(img.image_file_path, 'images/default.jpg') AS primary_image
        FROM products p
        LEFT JOIN product_images img 
            ON img.product_id = p.product_id
            AND img.is_primary = 1
        ORDER BY p.product_id
    ";

        return $this -> selectAll($sql);
    }

    // Fetch all products (frontend & admin)
    public function fetchProducts (array $filters = []): array {
        $sql = "SELECT * FROM {$this->products_table} WHERE 1=1";
        $params = [];

        // Filter by name
        if (!empty($filters['name'])) {
            $sql .= " AND product_name LIKE :name";
            $params['name'] = "%{$filters['name']}%";
        }

        // Filter by collection
        if (!empty($filters['collection'])) {
            $sql .= " AND collection_id = :collection_id";
            $params['collection_id'] = $filters['collection'];
        }

        // Filter by category
        if (!empty($filters['category'])) {
            $sql .= " AND category_id = :category_id";
            $params['category_id'] = $filters['category'];
        }

        // Filter by price range
        if (isset($filters['min_price'])) {
            $sql .= " AND product_price >= :min_price";
            $params['min_price'] = $filters['min_price'];
        }
        if (isset($filters['max_price'])) {
            $sql .= " AND product_price <= :max_price";
            $params['max_price'] = $filters['max_price'];
        }

        return $this -> selectAll($sql, $params);
    }

    // Fetch a single product by ID
    public function fetchProductById (int $id): array {
        $sql = "SELECT * FROM products WHERE product_id = ?";
        return $this -> selectOne($sql, [$id]);
    }

    public function fetchCollections (): array {
        $sql = "SELECT collection_name FROM collections ORDER BY collection_name";
        $rows = $this -> selectAll($sql);

        if (!$rows) {
            return [];
        }

        $collections = [];
        foreach ($rows as $row) {
            $collections[] = $row['collection_name'];
        }

        return $collections;
    }

    public function fetchCategories (): array {
        $sql = "SELECT category_name FROM categories ORDER BY category_name";
        $rows = $this -> selectAll($sql);

        if (!$rows) {
            return [];
        }

        $categories = [];
        foreach ($rows as $row) {
            $categories[] = $row['category_name'];
        }

        return $categories;
    }

    // Fetch product images
    public function fetchProductImages (int $product_id): array {
        $sql = "SELECT * FROM {$this->product_images_table} WHERE product_id = :product_id";
        return $this -> selectAll($sql, ['product_id' => $product_id]);
    }

    // Optional: generic search (for future features)
    public function searchProducts (string $keyword): array {
        $sql = "SELECT * FROM {$this->products_table} WHERE product_name LIKE :keyword";
        return $this -> selectAll($sql, ['keyword' => "%$keyword%"]);
    }
}