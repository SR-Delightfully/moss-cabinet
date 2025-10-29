<?php

namespace App\Controllers;

use App\Helpers\FlashMessage;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class FlashDemoController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'demo/flashDemoView.php', [
            'title' => 'Flash messages demo'
        ]);
    }
    public function success(Request $request, Response $response, array $args): Response
    {
        FlashMessage::success('Success!');
        return $this->redirect($request, $response, 'flash.demo');
    }
    public function error(Request $request, Response $response, array $args): Response
    {
        FlashMessage::error('An error occurred, cannot complete request.');
        return $this->redirect($request, $response, 'flash.demo');
    }
    public function info(Request $request, Response $response, array $args): Response
    {
        FlashMessage::info('Did you know that: ');
        return $this->redirect($request, $response, 'flash.demo');
    }
    public function warning(Request $request, Response $response, array $args): Response
    {
        FlashMessage::warning('Warning, please fix your inputs');
        return $this->redirect($request, $response, 'flash.demo');
    }
    public function multiple(Request $request, Response $response, array $args): Response
    {
        FlashMessage::success('Operation completed successfully!');
        FlashMessage::info('Remember to save your changes');
        FlashMessage::warning('Please review inputs before continuing');
        return $this->redirect($request, $response, 'flash.demo');
    }
}
