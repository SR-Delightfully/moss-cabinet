<?php

declare(strict_types=1);

/**
 * This file contains routes for the Web API exposed by this application.
 *
 * Client applications can interact with the exposed endpoints using AJAX.
 */

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

return static function (Slim\App $app): void {

    $app->group('/api', function (RouteCollectorProxy $group) {

        //* ROUTE: GET /api/status
        $group->get('/status', function (Request $request, Response $response, $args) {
            $payload = [
                "message" => "Reporting! Hello there!",
                "date" =>  date('Y-m-d H:i:s'),
            ];
            $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR));
            return $response;
        });
    });
};
