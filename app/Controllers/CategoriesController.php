<?php

namespace App\Controllers;

use App\Domain\Models\CategoriesModel;

use App\Domain\Models\CollectionsModel;
use App\Helpers\Core\PDOService;
use DI\Container;
use LDAP\Result;
use App\Domain\Models\ProductsModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CategoriesController extends BaseController {

    public function __construct (Container $container, private CategoriesModel $categories_model) {
        parent ::__construct($container); //pass the container to the parent

    }

// Signatures of controller methods: (callback methods)
    public function index (Request $request, Response $response, array $args): Response {

        $pdo = $this -> container -> get(PDOService::class);
        $model = new CategoriesModel($pdo);

        $query = $request -> getQueryParams();
        $search = $query["search"] ?? '';

        $categories = !empty($search) ? $model -> searchFilteredCategories($search) :
            $model -> getAllCategoriesWithProducts();


        $data = [
            'page_title' => 'Welcome to Moss Cabinets Categories Page',
            'contentView' => APP_VIEWS_PATH . '/categoriesView.php',
            'isNavBarShown' => true,
            'data' => [
                'title' => 'Categories',
                'message' => "categories",
                'categories' => $categories
            ]
        ];

        return $this -> render($response, 'common/layout.php', $data);

    }

//    public function handleGetShops (Request $request, Response $response, array $args) : Response {
//        $query = $request -> getQueryParams();
//        $search = $query["search"] ?? '';
//
//        $cafes = !empty($search) ? $this -> shops_model -> searchFilteredCoffes($search) :
//            $this -> shops_model -> fectchShops();
//        $data["page_title"] = "List of Shops";
//        $data["shops"] = $cafes;
//        $data["message"] = "Find your shop!";
//        return $this -> render($response, 'ShopsV.php', $data);
//    }

    public function show (Request $request, Response $response, array $args): Response {

        return $response;
    }

    public function create (Request $request, Response $response, array $args): Response {

        return $response;
    }

    public function edit (Request $request, Response $response, array $args): Response {

        return $response;
    }

    public function update (Request $request, Response $response, array $args): Response {

        return $response;
    }

    public function delete (Request $request, Response $response, array $args): Response {
        return $response;
    }
}