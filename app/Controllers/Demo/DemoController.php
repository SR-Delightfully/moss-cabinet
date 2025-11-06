<?php

namespace App\Controllers;

use App\Helpers\SessionManager;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DemoController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    // Show a simple counter page
    public function counter(Request $request, Response $response, array $args): Response
    {
        // Get and increment counter
        $counter = SessionManager::get('page_visits', 0) + 1;
        SessionManager::set('page_visits', $counter);

        return $this->render($response, 'demo/counterView.php', [
            'counter' => $counter,
            'title' => 'Visit Counter Demo'
        ]);
    }

    // Reset the counter
    public function resetCounter(Request $request, Response $response, array $args): Response
    {
        SessionManager::remove('page_visits');

        

        return $this->redirect($request, $response, 'demo.counter');
    }
}
