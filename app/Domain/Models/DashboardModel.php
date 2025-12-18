<?php
namespace App\Domain\Models;

class DashboardModel extends BaseModel
{
    public function getDashboardData(): array
    {
        return [
            'categories' => $this->selectAll("SELECT * FROM categories ORDER BY category_id ASC"),
            'collections'=> $this->selectAll("SELECT * FROM collections ORDER BY collection_id ASC"),
            'products'   => $this->selectAll("SELECT * FROM products ORDER BY product_id ASC"),
            'users'      => $this->selectAll("SELECT * FROM users ORDER BY user_id ASC"),
            'orders'     => $this->selectAll("SELECT * FROM orders ORDER BY order_id ASC")
        ];
    }
}