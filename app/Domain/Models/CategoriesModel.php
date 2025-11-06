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
class CategoriesModel extends BaseModel
{
   public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo); //pass it to the parent class
    }


//fetches the list of categories


    public function getCategories():mixed
    {
    // {$sql = "SELECT * FROM products";
    //     $products = $this->selectAll($sql);


    //  $sql = "SELECT * FROM {$this->categories}";
  $sql = "SELECT * FROM categories";

     $categories = $this->selectAll($sql);
             return $categories;

    }
}



