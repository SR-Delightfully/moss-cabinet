<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class ProductsModel extends BaseModel
{
    private string $products_table = "products";
    private string $collections_table = "collections";
    private string $categories_table = "categories";
    private string $product_images_table = "product_images";

    public function __construct(PDOService $pdoService)
    {
        parent::__construct($pdoService);
    }

    // Fetch all products (frontend & admin)
    public function fetchProducts(array $filters = []): array
    {
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

        return $this->selectAll($sql, $params);
    }

    // Fetch a single product by ID
    public function fetchProductById(int $id): array
    {
        $sql = "SELECT * FROM {$this->products_table} WHERE id = :id";
        return $this->selectOne($sql, ['id' => $id]);
    }

    // Fetch all collections (for frontend filter)
    public function fetchCollections(): array
    {
        $sql = "SELECT * FROM {$this->collections_table}";
        return $this->selectAll($sql);
    }

    // Fetch all categories (for frontend filter)
    public function fetchCategories(): array
    {
        $sql = "SELECT * FROM {$this->categories_table}";
        return $this->selectAll($sql);
    }

    // Fetch product images
    public function fetchProductImages(int $product_id): array
    {
        $sql = "SELECT * FROM {$this->product_images_table} WHERE product_id = :product_id";
        return $this->selectAll($sql, ['product_id' => $product_id]);
    }

    // Optional: generic search (for future features)
    public function searchProducts(string $keyword): array
    {
        $sql = "SELECT * FROM {$this->products_table} WHERE product_name LIKE :keyword";
        return $this->selectAll($sql, ['keyword' => "%$keyword%"]);
    }
}
