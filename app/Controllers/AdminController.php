<!-- ? Can we delete this file if we have the DashboardController? -->
<?php

declare(strict_types=1);

namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AdminController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

public function index(Request $request, Response $response, array $args): Response
{
    $db = $this->container->get('db');

    // Fetch recent users
    $users = $db->query("
        SELECT user_id, user_first_name, user_last_name, user_email, user_created_at
        FROM users
        ORDER BY user_created_at DESC
        LIMIT 5
    ")->fetchAll();

    // Fetch recent products
    $products = $db->query("
        SELECT product_id, product_name, product_price, product_created_at
        FROM products
        ORDER BY product_created_at DESC
        LIMIT 5
    ")->fetchAll();

    // Fetch recent orders
    $orders = $db->query("
        SELECT order_id, user_id, order_total, order_status, order_created_at
        FROM orders
        ORDER BY order_created_at DESC
        LIMIT 5
    ")->fetchAll();

    // Fetch recent collections
    $collections = $db->query("
        SELECT collection_id, collection_name, collection_created_at
        FROM collections
        ORDER BY collection_created_at DESC
        LIMIT 5
    ")->fetchAll();

    // Fetch recent categories
    $categories = $db->query("
        SELECT category_id, category_name, category_created_at
        FROM categories
        ORDER BY category_created_at DESC
        LIMIT 5
    ")->fetchAll();

    // Pass all data to the dashboard view
    $data = [
        'page_title' => "Welcome to Moss Cabinet's admin dashboard",
        'contentView' => APP_VIEWS_PATH . 'admin/dashboardView.php',
        'isNavBarShown' => true,
        'data' => [
            'title' => 'Admin dashboard',
            'users' => $users,
            'products' => $products,
            'orders' => $orders,
            'collections' => $collections,
            'categories' => $categories
        ]
    ];

    return $this->render($response, 'common/layout.php', $data);
}


    public function error(Request $request, Response $response, array $args): Response
    {

        return $this->render($response, 'errorView.php');
    }
}
