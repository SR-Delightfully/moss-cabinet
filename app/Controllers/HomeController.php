<?php

declare(strict_types=1);

namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\Core\PDOService;

class HomeController extends BaseController
{
    protected PDOService $db;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->db = $container->get(PDOService::class);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        $categoriesStmt = $this->db->getPDO()->prepare("
            SELECT DISTINCT cat.category_id, cat.category_name
            FROM categories cat
            INNER JOIN products p ON p.category_id = cat.category_id
            INNER JOIN collections c ON p.collection_id = c.collection_id
            ORDER BY cat.category_name ASC
        ");
        $categoriesStmt->execute();
        $categories = $categoriesStmt->fetchAll(\PDO::FETCH_ASSOC);

        $data = [
            'page_title' => 'Welcome to Moss Cabinet',
            'contentView' => APP_VIEWS_PATH . '/homeView.php',
            'isNavBarShown' => true,
            'data' => [
                'categories' => $categories,
            ]
        ];

        return $this->render($response, 'common/layout.php', $data);
    }

    public function error(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'errorView.php');
    }
}
