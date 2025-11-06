<?php

namespace App\Controllers;

use DI\Container;
use LDAP\Result;
use App\Domain\Models\ProductsModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProductsController extends BaseController
{
    public function __construct(
        Container $container,
        private ProductsModel $products_model
    ) {
        parent::__construct($container); //pass the container to the parent
    }

    //*GET admin/products
    /**
     *  Display a list of items.
     * @param \Psr\Http\Message\ServerRequestInterface $request HTTP request
     * @param \Psr\Http\Message\ResponseInterface $response HTTP response
     * @param array $args
     * @return Response
     */
    public function index(Request $request, Response $response, array $args): Response
    {
        $products = $this->products_model->fetchProducts();
        $data['data'] = [
            'page_title' => 'List of products',
            'message' => 'Welcome to the home page',
            'products' => $products
        ];
        // $data["page_title"] = "Browse Products";
        // $data["products"] = $products;
        return $this->render($response, 'admin/products/productsIndexView.php', $data);
    }

    /**
     * Show details of a single item.
     * @return void
     */
    public function show(Request $request, Response $response, array $args): Response
    {
        return $response;
    }

    /**
     *  Display a form to create a new item.
     * @return void
     */
    public function create(Request $request, Response $response, array $args): Response
    {
        return $response;
    }

    /**
     * Save a new item to the database.
     * @return void
     */
    public function store(Request $request, Response $response, array $args): Response
    {
        return $response;
    }

    /**
     * Display a form to edit an item.
     * @return void
     */
    public function edit(Request $request, Response $response, array $args): Response
    {
        //* 1) Get the id of the product from the query string params of the URI
        $query_params = $request->getQueryParams();
        // dd("Editing product: ".$product_id["id"]);
        $id = $query_params["id"];

        //* 2)  Pull the existing item identified by the received ID from the db.
        $product = $this->products_model->fetchProductById($id);
        // dd($product);

        //* 3) Pass it to the view where the update/editing form filled with the item info will be rendered
        $data = [
            'product' => []
        ];
        return $this->render($response, 'admin/products/productsIndexView.php', $data);
    }

    /**
     * Save changes to an item.
     * @return void
     */
    public function update(Request $request, Response $response, array $args): Response
    {
        return $response;
    }

    /**
     * Remove an item.
     * @return void
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $response;
    }


    public function error(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'errorView.php');
    }
}
