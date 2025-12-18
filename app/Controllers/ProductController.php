<?php

declare(strict_types = 1);

namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Models\ProductsModel;
use App\Helpers\PDOService;

class ProductController extends BaseController {
    //NOTE: Passing the entire container violates the Dependency Inversion Principle and creates a service locator anti-pattern.
    // However, it is a simple and effective way to pass the container to the controller given the small scope of the application and the fact that this application is to be used in a classroom setting where students are not yet familiar with the Dependency Inversion Principle.
    public function __construct (Container $container, private ProductsModel $productsModel) {
        parent ::__construct($container);
    }

    public function details (Request $request, Response $response, array $args) : Response {
        $product_id = $args["product_id"];
        $product = $this -> products_model -> fetchProductById($product_id);
        $images = $this -> products_model -> fetchProductImages($product_id);

        $data = [
            "page_title" => $product["name"],
            "product" => [$product],
            "images" => [$images],
        ];
        return $this->render($response, 'common/layout.php', $data);
    }


    public
    function error (Request $request, Response $response, array $args): Response {

        return $this -> render($response, 'errorView.php');
    }
}
