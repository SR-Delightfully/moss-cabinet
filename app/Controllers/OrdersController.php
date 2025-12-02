<?php

namespace App\Controllers;

use App\Domain\Models\OrdersModel;

use DI\Container;
use LDAP\Result;
use App\Domain\Models\ProductsModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class OrdersController extends BaseController
{

    public function __construct(Container $container, private OrdersModel $orders_model)
    {
        parent::__construct($container); //pass the container to the parent

    }

    // Signatures of controller methods: (callback methods)
    public function index(Request $request, Response $response, array $args): Response
    {

        $orders = $this->orders_model->getOrders();
        $data['data'] = [
            'title' => 'List of orders',
            'message' => 'Welcome to the home page',
            'orders' => $orders
        ];
        return $this->render($response, '<admin>
    <orders>ordersIndexView.php', $data);
    }


    public function show(Request $request, Response $response, array $args): Response
    {

        return $response;
    }
    public function create(Request $request, Response $response, array $args): Response
    {

        return $response;
    }
    public function edit(Request $request, Response $response, array $args): Response
    {

        return $response;
    }
    public function update(Request $request, Response $response, array $args): Response
    {

        return $response;
    }
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $response;
    }
}
