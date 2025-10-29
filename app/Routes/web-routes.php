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
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


return static function (Slim\App $app): void {


    //* NOTE: Route naming pattern: [controller_name].[method_name]
    $app->get('/', [HomeController::class, 'index'])
        ->setName('home.index');

    $app->get('/home', [HomeController::class, 'index'])
        ->setName('home.index');



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
