<?php

declare(strict_types=1);

namespace App\Controllers;

use DI\Container;
use App\Helpers\FlashMessage;
use App\Domain\Models\DashboardModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AdminController extends BaseController
{
    protected DashboardModel $dashboardModel;

    public function __construct(Container $container, DashboardModel $dashboardModel)
    {
        parent::__construct($container);
        $this->dashboardModel = $dashboardModel;
    }

    /**
     * Render the main admin dashboard
     */
    public function index(Request $request, Response $response, array $args = []): Response
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

        // Render the dashboard view
        ob_start();
        require APP_VIEWS_PATH . '/admin/dashboardView.php';
        $adminContent = ob_get_clean();

        ob_start();
        require APP_VIEWS_PATH . '/admin/adminHeader.php';
        $html = ob_get_clean();

        $response->getBody()->write($html);
        return $response;
    }

    /**
     * List of allowed tables and primary keys
     */
    private function allowedTables(): array
    {
        return [
            'users'      => 'user_id',
            'products'   => 'product_id',
            'orders'     => 'order_id',
            'collections'=> 'collection_id',
            'categories' => 'category_id'
        ];
    }

    private function resolveTable(string $table): array
    {
        $tables = $this->allowedTables();

        if (!isset($tables[$table])) {
            throw new \RuntimeException('Invalid table: ' . $table);
        }

        return [$table, $tables[$table]];
    }

    /**
     * Create a new record
     */
    public function create(Request $request, Response $response, array $args): Response
    {
        [$table, $pk] = $this->resolveTable($args['table']);
        $db = $this->container->get('db');

        $data = $request->getParsedBody();
        unset($data[$pk]); // ID is auto-generated

        if (!empty($data)) {
            $cols = array_keys($data);
            $sql = sprintf(
                "INSERT INTO %s (%s) VALUES (%s)",
                $table,
                implode(',', $cols),
                ':' . implode(',:', $cols)
            );

            $stmt = $db->prepare($sql);
            $stmt->execute($data);

            FlashMessage::success(ucfirst($table) . ' created successfully.');
        } else {
            FlashMessage::error('No data submitted.');
        }

        return $this->index($request, $response);
    }

    /**
     * Update an existing record
     */
    public function update(Request $request, Response $response, array $args): Response
    {
        [$table, $pk] = $this->resolveTable($args['table']);
        $db = $this->container->get('db');

        $id = (int)($request->getParsedBody()[$pk] ?? 0);
        $data = $request->getParsedBody();
        unset($data[$pk]);

        if (!empty($data) && $id) {
            $set = implode(', ', array_map(fn($c) => "$c = :$c", array_keys($data)));
            $data['id'] = $id;

            $sql = "UPDATE {$table} SET {$set} WHERE {$pk} = :id";
            $stmt = $db->prepare($sql);
            $stmt->execute($data);

            FlashMessage::success(ucfirst($table) . ' updated successfully.');
        } else {
            FlashMessage::error('No data submitted for update.');
        }

        return $this->index($request, $response);
    }

    /**
     * Delete a record
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        [$table, $pk] = $this->resolveTable($args['table']);
        $db = $this->container->get('db');

        $id = (int)($request->getParsedBody()[$pk] ?? 0);

        if ($id) {
            $stmt = $db->prepare("DELETE FROM {$table} WHERE {$pk} = :id");
            $stmt->execute(['id' => $id]);

            FlashMessage::warning(ucfirst($table) . ' deleted successfully.');
        } else {
            FlashMessage::error('Invalid record for deletion.');
        }

        return $this->index($request, $response);
    }

    /**
     * Fallback error
     */
    public function error(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'errorView.php');
    }
}
