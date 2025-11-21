<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;
use PDO;

class CollectionsModel extends BaseModel
{
    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }

    /**
     * Fetch all collections with their products and primary images.
     */
    public function getAllCollectionsWithProducts(): array
    {
        $sql = "
            SELECT
                c.collection_id,
                c.collection_name,

                p.product_id,
                p.product_name,
                p.product_price,

                img.image_file_path AS primary_image

            FROM collections c
            LEFT JOIN products p 
                ON p.collection_id = c.collection_id

            LEFT JOIN product_images img 
                ON img.product_id = p.product_id
                AND img.is_primary = 1

            ORDER BY c.collection_id, p.product_id
        ";

        $rows = $this->selectAll($sql);

        if (!$rows) {
            return [];
        }

        $collections = [];

        foreach ($rows as $row) {

            $cid = $row['collection_id'];

            if (!isset($collections[$cid])) {
                $collections[$cid] = [
                    'collection_id'   => $row['collection_id'],
                    'collection_name' => $row['collection_name'],
                    'products'        => []
                ];
            }

            if (!empty($row['product_id'])) {
                $collections[$cid]['products'][] = [
                    'product_id'    => $row['product_id'],
                    'product_name'  => $row['product_name'],
                    'product_price' => $row['product_price'],
                    'primary_image' => $row['primary_image'] ?: 'images/default.jpg'
                ];
            }
        }

        return array_values($collections);
    }
}
