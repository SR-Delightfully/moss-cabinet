<?php

namespace App\Controllers;

use App\Domain\Models\DashboardModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DashboardController extends BaseController
{
    protected DashboardModel $dashboardModel;

    public function __construct(Container $container, DashboardModel $dashboardModel)
    {
        parent::__construct($container); 
        $this->dashboardModel = $dashboardModel;
    }
public function index(Request $request, Response $response): Response
{
    $tables = $this->dashboardModel->getDashboardData();

    $data = [
        'page_title' => 'Admin Dashboard',
        'tables'     => $tables,
    ];

    // Capture dashboard content
    ob_start();
    require APP_VIEWS_PATH . '/admin/dashboardView.php';
    $adminContent = ob_get_clean();

    // Include the header (layout + sidebar + topbar)
    ob_start();
    require APP_VIEWS_PATH . '/admin/adminHeader.php';
    $html = ob_get_clean();

    $response->getBody()->write($html);
    return $response;
}

}
