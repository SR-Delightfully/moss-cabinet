<?php
namespace App\Controllers;

use App\Helpers\UserContext;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProfileController
{
    public function view(Request $request, Response $response): Response
    {
        $user = UserContext::getCurrentUser();

        if (!$user) {
            return $response
                ->withHeader('Location', '/signin')
                ->withStatus(302);
        }

        $response->getBody()->write("Welcome, {$user['user_fname']}!");
        return $response;
    }
}
