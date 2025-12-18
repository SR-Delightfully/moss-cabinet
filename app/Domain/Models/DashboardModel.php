<?php

namespace App\Domain\Models;

class DashboardModel extends BaseModel
{
    public function getDashboardData(): array
    {
        return [
            'categories'  => $this->selectAll("SELECT * FROM categories ORDER BY category_id ASC"),
            'collections' => $this->selectAll("SELECT * FROM collections ORDER BY collection_id ASC"),
            'products'    => $this->selectAll("SELECT * FROM products ORDER BY product_id ASC"),
            'users'       => $this->selectAll("SELECT * FROM users ORDER BY user_id ASC"),
            'orders'      => $this->selectAll("SELECT * FROM orders ORDER BY order_id ASC"),
        ];
    }

    public function getRecentProducts(int $limit = 5): array
    {
        return $this->selectAll("
            SELECT 
                p.product_id,
                p.product_name,
                c.category_name
            FROM products p
            LEFT JOIN categories c ON c.category_id = p.category_id
            ORDER BY p.product_created_at DESC
            LIMIT {$limit}
        ");
    }

    public function getRecentOrders(int $limit = 5): array
    {
        return $this->selectAll("
            SELECT 
                o.order_id,
                o.user_id,
                CONCAT(u.user_first_name, ' ', u.user_last_name) AS user_name,
                o.order_total,
                o.order_created_at
            FROM orders o
            LEFT JOIN users u ON u.user_id = o.user_id
            ORDER BY o.order_created_at DESC
            LIMIT {$limit}
        ");
    }


    public function getOrdersOverTime(): array
    {
        return $this->selectAll("
            SELECT DATE(order_created_at) AS date, SUM(order_total) AS revenue, COUNT(*) AS count
            FROM orders
            GROUP BY DATE(order_created_at)
            ORDER BY DATE(order_created_at) ASC
        ");
    }



    public function getProductsByCategory(): array
    {
        return $this->selectAll("
            SELECT c.category_name, COUNT(p.product_id) AS count
            FROM products p
            LEFT JOIN categories c ON c.category_id = p.category_id
            GROUP BY c.category_name
            ORDER BY c.category_name ASC
        ");
    }

    public function getLowStockProducts(int $threshold = 5): array
    {
        return $this->selectAll("
            SELECT p.product_name, c.category_name, p.product_stock_quantity AS stock_quantity
            FROM products p
            LEFT JOIN categories c ON c.category_id = p.category_id
            WHERE p.product_stock_quantity <= {$threshold}
            ORDER BY p.product_stock_quantity ASC
        ");
    }

}