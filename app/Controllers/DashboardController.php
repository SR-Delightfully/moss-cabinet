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

        $summary = [
            ['title' => 'Users', 'value' => count($tables['users'] ?? [])],
            ['title' => 'Products', 'value' => count($tables['products'] ?? [])],
            ['title' => 'Orders', 'value' => count($tables['orders'] ?? [])],
            ['title' => 'Revenue', 'value' => '$' . number_format(array_sum(array_column($tables['orders'] ?? [], 'total')), 2)],
        ];

        $charts = [
            [
                'id'    => 'ordersOverTime',
                'title' => 'Orders Over Time',
                'type'  => 'line',
                'label' => 'Orders',
                'data'  => array_column($this->dashboardModel->getOrdersOverTime(), 'count', 'date'),
            ],
            [
                'id'    => 'productsByCategory',
                'title' => 'Products by Category',
                'type'  => 'bar',
                'label' => 'Products',
                'data'  => array_column($this->dashboardModel->getProductsByCategory(), 'count', 'category_name'),
            ],
        ];

        $recentOrders   = $this->dashboardModel->getRecentOrders();
        $recentProducts = $this->dashboardModel->getRecentProducts();
        $lowStock       = $this->dashboardModel->getLowStockProducts();

        $page_title = 'Admin Dashboard';

        ob_start();
        require APP_VIEWS_PATH . '/admin/dashboardView.php';
        $adminContent = ob_get_clean();

        ob_start();
        require APP_VIEWS_PATH . '/admin/adminHeader.php';
        $html = ob_get_clean();

        $response->getBody()->write($html);
        return $response;
    }
}