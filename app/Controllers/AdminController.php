<?php

declare(strict_types=1);

namespace App\Controllers;

use DI\Container;
use App\Helpers\FlashMessage;
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

        $users = $db->query("
            SELECT user_id, user_first_name, user_last_name, user_email, user_created_at
            FROM users
            ORDER BY user_created_at DESC
            LIMIT 5
        ")->fetchAll();

        $products = $db->query("
            SELECT product_id, product_name, product_price, product_created_at
            FROM products
            ORDER BY product_created_at DESC
            LIMIT 5
        ")->fetchAll();

        $orders = $db->query("
            SELECT order_id, user_id, order_total, order_status, order_created_at
            FROM orders
            ORDER BY order_created_at DESC
            LIMIT 5
        ")->fetchAll();

        $collections = $db->query("
            SELECT collection_id, collection_name, collection_created_at
            FROM collections
            ORDER BY collection_created_at DESC
            LIMIT 5
        ")->fetchAll();

        $categories = $db->query("
            SELECT category_id, category_name, category_created_at
            FROM categories
            ORDER BY category_created_at DESC
            LIMIT 5
        ")->fetchAll();

        $data = [
            'page_title' => "Welcome to Moss Cabinet's admin dashboard",
            'contentView' => APP_VIEWS_PATH . 'admin/dashboardView.php',
            'isNavBarShown' => true,
            'data' => [
                'users' => $users,
                'products' => $products,
                'orders' => $orders,
                'collections' => $collections,
                'categories' => $categories
            ]
        ];

        return $this->render($response, 'common/layout.php', $data);
    }

    private function allowedTables(): array
    {
        return [
            'users' => 'user_id',
            'products' => 'product_id',
            'orders' => 'order_id',
            'collections' => 'collection_id',
            'categories' => 'category_id'
        ];
    }

    private function resolveTable(string $table): array
    {
        $tables = $this->allowedTables();

        if (!isset($tables[$table])) {
            throw new \RuntimeException('Invalid table');
        }

        return [$table, $tables[$table]];
    }

    public function create(Request $request, Response $response, array $args): Response
    {
        [$table, $pk] = $this->resolveTable($args['table']);
        $db = $this->container->get('db');

        $data = $request->getParsedBody();
        unset($data[$pk]);

        if (empty($data)) {
            FlashMessage::error('No data submitted.');
            return $response->redirect('/admin');
        }

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
        return $response->redirect('/admin');
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        [$table, $pk] = $this->resolveTable($args['table']);
        $db = $this->container->get('db');

        $id = (int)$args['id'];
        $data = $request->getParsedBody();
        unset($data[$pk]);

        $set = implode(', ', array_map(fn($c) => "$c = :$c", array_keys($data)));
        $data['id'] = $id;

        $sql = "UPDATE {$table} SET {$set} WHERE {$pk} = :id";

        $stmt = $db->prepare($sql);
        $stmt->execute($data);

        FlashMessage::success(ucfirst($table) . ' updated.');
        return $response->redirect('/admin');
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        [$table, $pk] = $this->resolveTable($args['table']);
        $db = $this->container->get('db');

        $id = (int)$args['id'];

        $stmt = $db->prepare("DELETE FROM {$table} WHERE {$pk} = :id");
        $stmt->execute(['id' => $id]);

        FlashMessage::warning(ucfirst($table) . ' deleted.');
        return $response->redirect('/admin');
    }

    public function error(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'errorView.php');
    }
}
