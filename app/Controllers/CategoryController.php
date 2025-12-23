<?php

declare(strict_types=1);

namespace App\Controllers;

use DI\Container;
use App\Domain\Models\CategoriesModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CategoryController extends BaseController
{
    private CategoriesModel $categoriesModel;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->categoriesModel = new CategoriesModel(
            $container->get(\App\Helpers\Core\PDOService::class)
        );
    }

    // List all categories
    public function index(Request $request, Response $response, array $args): Response
    {
        $categories = $this->categoriesModel->getAllCategoriesWithProducts();
        $data = [
            'page_title' => 'Categories',
            'tables' => [
                'Categories' => $categories
            ],
        ];

        return $this->render($response, 'admin/adminView.php', $data);
    }

    // Create a new category
    public function create(Request $request, Response $response, array $args): Response
    {
        $post = $request->getParsedBody();
        $name = $post['category_name'] ?? '';
        $description = $post['category_description'] ?? null;

        $this->categoriesModel->create($name, $description);

        return $response->withHeader('Location', '/admin/categories')->withStatus(302);
    }

    // Update existing category
    public function update(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $post = $request->getParsedBody();
        $name = $post['category_name'] ?? '';
        $description = $post['category_description'] ?? null;

        $this->categoriesModel->update($id, $name, $description);

        return $response->withHeader('Location', '/admin/categories')->withStatus(302);
    }

    // Delete category
    public function delete(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $this->categoriesModel->delete($id);

        return $response->withHeader('Location', '/admin/categories')->withStatus(302);
    }
}
