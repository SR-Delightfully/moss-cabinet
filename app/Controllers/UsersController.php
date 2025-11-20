<?php

namespace App\Controllers;

use App\Domain\Models\UsersModel;

use DI\Container;
use LDAP\Result;
use App\Domain\Models\ProductsModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UsersController extends BaseController
{

    public function __construct(Container $container, private UsersModel $users_model)
    {
        parent::__construct($container); //pass the container to the parent

    }

    // Signatures of controller methods: (callback methods)
    public function index(Request $request, Response $response, array $args): Response
    {

        //NOTE: disabled for testing  the lab (file upload)
        // $users = $this->users_model->getUsers();
        $data['data'] = [
            'title' => 'List of users',
            'message' => 'Welcome to the home page',
            // 'users' => $users
        ];
        //*NOTE: the view of the path must not contain HTML tags. It should be a relative path. E.g., admin/users/userIndexView.php
        return $this->render($response, 'admin/users/usersIndexView.php', $data);
    }


    public function show(Request $request, Response $response, array $args): Response
    {

        return $response;
    }
public function create(Request $request, Response $response, array $args): Response
{
    $data = $request->getParsedBody();

    $username = trim($data['username'] ?? '');
    $first_name = trim($data['first-name'] ?? '');
    $last_name = trim($data['last-name'] ?? '');
    $email = trim($data['email'] ?? '');
    $password = $data['password'] ?? '';
    $confirm_password = $data['confirm-password'] ?? '';

    // Validate passwords match
    if ($password !== $confirm_password) {
        FlashMessage::add('error', 'Passwords do not match.');
        return $response
            ->withHeader('Location', '/sign-up')
            ->withStatus(302);
    }

    // Hash password
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insert into database 
    $this->users_model->createUser([
        'username'    => $username,
        'first_name'  => $first_name,
        'last_name'   => $last_name,
        'email'       => $email,
        'password'    => $password_hashed,
    ]);

    FlashMessage::add('success', 'Registration successful! You may now sign in.');

    // Redirect to login
    return $response
        ->withHeader('Location', './sign-in')
        ->withStatus(302);
}

    public function edit(Request $request, Response $response, array $args): Response
    {

        return $response;
    }
    public function update(Request $request, Response $response, array $args): Response
    {

        return $response;
    }
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $response;
    }
}
