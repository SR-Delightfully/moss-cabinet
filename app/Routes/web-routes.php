<?php

declare(strict_types=1);

/**
 * This file contains the routes for the web application.
 */

use App\Helpers\FlashMessage;
use App\Controllers\FlashDemoController;
use App\Helpers\SessionManager;
use App\Controllers\DemoController;
use App\Controllers\HomeController;
use App\Controllers\ProductsController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


return static function (Slim\App $app): void {


    //* NOTE: Route naming pattern: [controller_name].[method_name]
    $app->get('/', [HomeController::class, 'index'])
        ->setName('home.index');

    $app->get('/home', [HomeController::class, 'index'])
        ->setName('home.index');


    // to view Login form:
    // $app->get('/login', [LoginController::class, 'index'])
    //     ->setName('login.index');

    // to view Registration form:
    // $app->get('/signup', [SignupController::class, 'index'])
    //     ->setName('signup.index');

    // to view a list of user profiles:
    // $app->get('/profiles', [ShopsController::class, 'index'])
    //     ->setName('profiles.index');

    // to view a the profile of a single user:
    // $app->get('/profiles/[profile_id]', [ShopsController::class, 'index'])
    //     ->setName('profile.index');

    // to view a list of shops hosted by moss cabinet:
    // $app->get('/shops', [ShopsController::class, 'index'])
    //     ->setName('shops.index');

    // to view each shop and display their information and showcase their products:
    // $app->get('/shops/[shop_id]', [ShopController::class, 'index'])
    //     ->setName('shop.index');

    // to view all product categories available on moss cabinet
    // $app->get('/categories', [CategoriesController::class, 'index'])
    //     ->setName('categories.index');

    // to view all products within a specific category
    // $app->get('/categories/[category_id]', [CategoryController::class, 'index'])
    //     ->setName('category.index');

    // to view all products available on moss cabinet
    $app->get('/products', [ProductsController::class, 'index'])
        ->setName('products.index');

    // to view a single product and its details
    // $app->get('/products/[product_id]', [ProductController::class, 'index'])
    //     ->setName('product.index');

    // to view the user's cart and a listing of the products inside it.
    // $app->get('/cart', [CartController::class, 'index'])
    //     ->setName('cart.index');

    // to view the checkout form to validate the purchase of the items in the cart.
    // $app->get('/cart/checkout', [CartCheckoutController::class, 'index'])
    //     ->setName('checkout.index');



    // A route to test runtime error handling and custom exceptions.
    // $app->get('/error', function (Request $request, Response $response, $args) {
    //     throw new \Slim\Exception\HttpNotFoundException($request, "Something went wrong");
    // });

    $app->get('/demo/counter', [DemoController::class, 'counter'])->setName('demo.counter');
    $app->post('/demo/reset', [DemoController::class, 'resetCounter'])->setName('demo.reset');

    $app->get('/test-session', function ($request, $response) {
        // Get current counter, increment it
        $counter = SessionManager::get('counter', 0) + 1;
        SessionManager::set('counter', $counter);
        // FlashMessage::add('success', 'Refresh successful! Welcome back.');
        $response->getBody()->write("Counter: " . $counter);
        return $response->withHeader('Location', '/counter')->withStatus(302);
    });

    // Flash message demo routes
    $app->get('/flash', [FlashDemoController::class, 'index'])->setName('flash.demo');
    $app->post('/flash/success', [FlashDemoController::class, 'success'])->setName('flash.success');
    $app->post('/flash/error', [FlashDemoController::class, 'error'])->setName('flash.error');
    $app->post('/flash/info', [FlashDemoController::class, 'info'])->setName('flash.info');
    $app->post('/flash/warning', [FlashDemoController::class, 'warning'])->setName('flash.warning');
    $app->post('/flash/multiple', [FlashDemoController::class, 'multiple'])->setName('flash.multiple');
};
