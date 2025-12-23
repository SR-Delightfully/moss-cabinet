<?php

namespace App\Controllers;

use App\Domain\Models\CategoriesModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CategoriesController extends BaseController
{
    private CategoriesModel $categories_model;

    public function __construct(Container $container, CategoriesModel $categories_model)
    {
        parent::__construct($container); // Pass container to BaseController
        $this->categories_model = $categories_model;
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        $categories = $this->categories_model->getAllCategoriesWithProducts();

        $data = [
            'page_title' => 'Categories Admin',
            'contentView' => APP_VIEWS_PATH . '/categoriesView.php',
            'isNavBarShown' => true,
            'data' => [
                'categories' => $categories
            ]
        ];

        return $this->render($response, 'common/layout.php', $data);
    }

    public function create(Request $request, Response $response, array $args): Response
    {
        $post = $request->getParsedBody();
        $name = $post['category_name'] ?? null;
        $desc = $post['category_description'] ?? null;

        if ($name) {
            $this->categories_model->create($name, $desc);
        }

        return $response->withHeader('Location', '/admin/categories')->withStatus(302);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'] ?? null;
        if (!$id) {
            return $response->withStatus(400)->write('Invalid category ID');
        }

        $post = $request->getParsedBody();
        $name = $post['category_name'] ?? null;
        $desc = $post['category_description'] ?? null;

        if ($name) {
            $this->categories_model->update((int)$id, $name, $desc);
        }

        return $response->withHeader('Location', '/admin/categories')->withStatus(302);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'] ?? null;
        if ($id) {
            $this->categories_model->delete((int)$id);
        }

        return $response->withHeader('Location', '/admin/categories')->withStatus(302);
    }
}
