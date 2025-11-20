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
          $data = [
            'page_title' => "Welcome to Moss Cabinet's admin dashboard",
            'contentView' => APP_VIEWS_PATH . 'admin/dashboardView.php',
            'isNavBarShown' => true,
            'data' => [
                'title' => 'Admin dashboard',
                'message' => "dashboard",
            ]
        ];

        return $this->render($response, 'common/layout.php', $data);
    }

    public function error(Request $request, Response $response, array $args): Response
    {

        return $this->render($response, 'errorView.php');
    }
}
