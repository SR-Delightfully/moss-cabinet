<?php

namespace App\Controllers;

use DI\Container;
use App\Domain\Models\ProductsModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProductsController extends BaseController
{
    public function __construct(
        Container $container,
        private ProductsModel $products_model
    ) {
        parent::__construct($container);
    }

    // Admin: /admin/products
    public function adminIndex(Request $request, Response $response, array $args): Response
    {
        $products = $this->products_model->fetchProducts();

        $data = [
            'page_title' => 'Admin: List of Products',
            'products' => $products
        ];

        return $this->render($response, 'admin/products/productsIndexView.php', $data);
    }

    // Frontend: /products
    public function index(Request $request, Response $response, array $args): Response
    {
        $products = $this->products_model->fetchProducts();
        $collections = $this->products_model->fetchCollections();
        $categories = $this->products_model->fetchCategories();

        $data = [
            'page_title' => 'All Products',
            'contentView' => APP_VIEWS_PATH . '/productsView.php',
            'isNavBarShown' => true,
            'data' => [
                'products' => $products,
                'collections' => $collections,
                'categories' => $categories
            ]
        ];

        return $this->render($response, 'common/layout.php', $data);
    }

    // Frontend: /product/{id}
    public function show(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'] ?? null;
        if (!$id) {
            return $this->error($request, $response, $args);
        }

        $product = $this->products_model->fetchProductById($id);
        $images = $this->products_model->fetchProductImages($id);

        $data = [
            'page_title' => $product['product_name'] ?? 'Product',
            'contentView' => APP_VIEWS_PATH . '/products/productView.php',
            'isNavBarShown' => true,
            'data' => [
                'product' => $product,
                'images' => $images
            ]
        ];

        return $this->render($response, 'common/layout.php', $data);
    }

    // Reusable error handler
    public function error(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'errorView.php');
    }
}
