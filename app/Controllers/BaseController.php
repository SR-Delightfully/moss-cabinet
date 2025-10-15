<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Core\AppSettings;
use Slim\Views\PhpRenderer;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

abstract class BaseController
{
    protected PhpRenderer $view;
    protected AppSettings $settings;
    protected Container $container;

    //NOTE: Passing the entire DI container violates the Dependency Inversion Principle and creates a service locator anti-pattern.
    // However, it is a simple and effective way to pass the container to the controller given the small scope of the application and the fact that this application is to be used in a classroom setting where students are not yet familiar with the Dependency Inversion Principle.
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->settings = $container->get(AppSettings::class);
        $this->view = $container->get(PhpRenderer::class);
    }

    /**
     * Renders a view template with the provided data and returns a response.
     *
     * This method uses Slim's PhpRenderer to render a view template with the given data
     * and returns a PSR-7 response object with the rendered content. The Content-Type header
     * is set to 'text/html; charset=utf-8' to indicate that the response contains HTML content.
     *
     * @param Response $response The PSR-7 response object to be modified with rendered content.
     * @param string $view_name The name of the view template to render (must be a valid view file)
     * @param array $data Associative array of data to be passed to the view template.
     *
     * @return Response The modified response object with rendered content and appropriate headers.
     *
     * @throws \InvalidArgumentException  If header names or values is invalid.
     * @throws \Slim\Exception\HttpInternalServerErrorException If the view cannot be rendered.
     *
     */
    protected function render(Response $response, string $view_name, array $data = []): Response
    {
        $response = $response->withHeader('Content-Type', 'text/html; charset=utf-8');
        //dd($data);
        return $this->view->render($response, $view_name, $data);
    }

    /**
     * Redirects the client to a named route with optional route parameters and query strings.
     *
     * Creates a redirect response by resolving the route name to a URI using Slim's RouteParser
     * and setting the appropriate Location header with the specified HTTP status code. Supports
     * both route pattern placeholders (e.g., /users/{id}) and query string parameters.
     *
     *
     * @param Request $request The PSR-7 request object used to extract route context
     * @param Response $response The PSR-7 response object to be modified with redirect headers
     * @param string $route_name The named route to redirect to (must be a valid route name)
     * @param array $uri_args Associative array for route placeholders (e.g., ['id' => 123] for /users/{id})
     * @param array $query_params Associative array of query parameters to append to the URL
     * @param int $status The HTTP status code for the redirect (default: 302 Found)
     *
     * @return Response The modified response object with Location header and status code set
     *
     * @throws InvalidArgumentException If the route name is not found or invalid
     * @throws RuntimeException If the route parser cannot generate a valid URL
     *
     * @example
     * // Basic redirect (no parameters)
     * return $this->redirect($request, $response, 'home.index');
     *
     * // Redirect with route parameters (for route: /users/{id})
     * return $this->redirect($request, $response, 'user.profile', ['id' => 123]);
     *
     * // Redirect with query parameters only
     * return $this->redirect($request, $response, 'search.index', [], ['q' => 'term', 'page' => 2]);
     *
     * // Redirect with both route parameters and query strings (for route: /users/{id}/edit)
     * return $this->redirect($request, $response, 'user.edit', ['id' => 123], ['tab' => 'settings']);
     */
    protected function redirect(Request $request, Response $response, string $route_name, array $uri_args = [], array $query_params = []): Response
    {
        $route_parser = RouteContext::fromRequest($request)->getRouteParser();
        $target_uri = $route_parser->urlFor($route_name, $uri_args, $query_params);
        return $response->withStatus(302)->withHeader('Location', $target_uri);
    }
}
