<?php

namespace App\Middleware;

use App\Helpers\SessionManager;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;

class SessionMiddleware implements MiddlewareInterface
{
    public function process(
        Request $request,
        Handler $handler
    ): Response {
        // Start session using SessionManager
        SessionManager::start();

        // Continue to next middleware/route
        return $handler->handle($request);
    }
}
