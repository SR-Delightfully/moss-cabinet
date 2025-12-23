<?php

declare(strict_types=1);

namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Models\UserModel;
use App\Helpers\UserContext;
use App\Helpers\FlashMessage;
use Slim\Routing\RouteContext;

class AuthController extends BaseController
{
    private UserModel $userModel;

    public function __construct(Container $container)
    {
        parent::__construct($container);

        // Inject UserModel via container
        $this->userModel = $container->get(UserModel::class);

        // Ensure session and user context initialized
        UserContext::init();
    }

    // -------------------------------
    // SIGN IN FORM
    // -------------------------------
    public function showSigninForm(Request $request, Response $response, array $args): Response
    {
        $data = [
            'page_title'   => 'Sign In',
            'contentView'  => APP_VIEWS_PATH . '/auth/signinView.php',
            'isNavBarShown'=> false,
            'data'         => []
        ];

        return $this->render($response, 'common/layout.php', $data);
    }


    // -------------------------------
    // SIGN UP
    // -------------------------------

    public function showSignupForm(Request $request, Response $response, array $args): Response
    {
        $data = [
            'page_title'   => 'Sign Up',
            'contentView'  => APP_VIEWS_PATH . '/auth/signupView.php',
            'isNavBarShown'=> false,
            'data'         => []
        ];

        return $this->render($response, 'common/layout.php', $data);
    }

    // -------------------------------
    // Forgot Password Form
    // -------------------------------
    public function showForgotPasswordForm(Request $request, Response $response, array $args): Response
    {
        $data = [
            'page_title'   => 'Forgot Password',
            'contentView'  => APP_VIEWS_PATH . '/auth/forgotPasswordView.php',
            'isNavBarShown'=> false,
            'data'         => []
        ];

        return $this->render($response, 'common/layout.php', $data);
    }

    // -------------------------------
    // Forgot Email Form
    // -------------------------------
    public function showForgotEmailForm(Request $request, Response $response, array $args): Response
    {
        $data = [
            'page_title'   => 'Forgot Email',
            'contentView'  => APP_VIEWS_PATH . '/auth/forgotEmailView.php',
            'isNavBarShown'=> false,
            'data'         => []
        ];

        return $this->render($response, 'common/layout.php', $data);
    }

    public function processSignup(Request $request, Response $response, array $args): Response
    {
        $post = $request->getParsedBody();

        $fname   = trim($post['first_name'] ?? '');
        $lname   = trim($post['last_name'] ?? '');
        $email   = trim($post['email'] ?? '');
        $pass    = trim($post['password'] ?? '');
        $confirm = trim($post['confirm_password'] ?? '');

        // Validation
        if (!$fname || !$lname || !$email || !$pass || !$confirm) {
            FlashMessage::error("Please fill in all fields.");
            return $this->showSignupForm($request, $response, $args);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            FlashMessage::error("Invalid email format.");
            return $this->showSignupForm($request, $response, $args);
        }

        if ($pass !== $confirm) {
            FlashMessage::error("Passwords do not match.");
            return $this->showSignupForm($request, $response, $args);
        }

        if ($this->userModel->findByEmail($email)) {
            FlashMessage::error("Email is already registered.");
            return $this->showSignupForm($request, $response, $args);
        }

        // Create unique username
        $username = strtolower($fname . '.' . $lname);
        $suffix = 1;
        $baseUsername = $username;
        while ($this->userModel->findByUsername($username)) {
            $username = $baseUsername . $suffix;
            $suffix++;
        }

        // Create user
        $this->userModel->createUser([
            'username'   => $username,
            'first_name' => $fname,
            'last_name'  => $lname,
            'email'      => $email,
            'password'   => $pass,
        ]);

        // Flash success message
        FlashMessage::success("Account created successfully! Please sign in.");

        // Redirect to sign-in page
        $basePath = $request->getUri()->getBasePath();
        return $response
            ->withHeader('Location', $basePath . '/sign-in')
            ->withStatus(302);
    }
    // -------------------------------
    // SIGN IN
    // -------------------------------
    public function processSignin(Request $request, Response $response, array $args): Response
    {
        $post = $request->getParsedBody();
        $email = trim($post['email'] ?? '');
        $password = trim($post['password'] ?? '');

        if (!$email || !$password) {
            FlashMessage::error("Please fill in all fields.");
            return $this->showSigninForm($request, $response, $args);
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['user_password_hashed'])) {
            FlashMessage::error("Invalid email or password.");
            return $this->showSigninForm($request, $response, $args);
        }

        // Log user in and normalize session keys
        UserContext::login([
            'user_username'    => $user['user_username'],
            'user_first_name'  => $user['user_first_name'],
            'user_last_name'   => $user['user_last_name'],
            'user_email'       => $user['user_email'],
            'user_pfp_src'     => $user['user_pfp_src'] ?? null,
            'is_admin'         => (strtoupper($user['user_role'] ?? '') === 'ADMIN'), // ✅ fixed
        ]);

        FlashMessage::success("Welcome back, " . htmlspecialchars($user['user_first_name']) . "!");

        // Redirect to homepage
        $routeContext = RouteContext::fromRequest($request);
        $basePath = $routeContext->getBasePath();

        return $response
            ->withHeader('Location', $basePath . '/')
            ->withStatus(302);
    }

    // -------------------------------
    // PROCESS FORGOT EMAIL
    // -------------------------------
    public function processForgotEmail(Request $request, Response $response, array $args): Response
    {
        $post = $request->getParsedBody();

        $fname = trim($post['first_name'] ?? '');
        $lname = trim($post['last_name'] ?? '');

        if (!$fname || !$lname) {
            FlashMessage::error("Please provide both first and last name.");
            return $this->showForgotEmailForm($request, $response, $args);
        }

        // Find user by name (you may already have this, otherwise add it)
        $user = $this->userModel->findByName($fname, $lname);

        if (!$user) {
            // Do NOT reveal whether the user exists
            FlashMessage::success(
                "If an account exists with that name, the email has been sent."
            );
            return $this->showForgotEmailForm($request, $response, $args);
        }

        // For now: show email directly (safe for small/private apps)
        FlashMessage::success(
            "Your account email is: <strong>" . htmlspecialchars($user['user_email']) . "</strong>"
        );

        return $this->showForgotEmailForm($request, $response, $args);
    }

    // -------------------------------
    // PROCESS FORGOT PASSWORD
    // -------------------------------
    public function processForgotPassword(Request $request, Response $response, array $args): Response
    {
        $post = $request->getParsedBody();
        $identifier = trim($post['identifier'] ?? ''); // username OR email

        if (!$identifier) {
            FlashMessage::error("Please enter your username or email address.");
            return $this->showForgotPasswordForm($request, $response, $args);
        }

        // Determine lookup method
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $user = $this->userModel->findByEmail($identifier);
        } else {
            $user = $this->userModel->findByUsername($identifier);
        }

        // Always return the same message
        if (!$user) {
            FlashMessage::success(
                "If an account exists, password reset instructions have been sent."
            );
            return $this->showForgotPasswordForm($request, $response, $args);
        }

        // Generate secure reset token
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', time() + 3600); // 1 hour

        $this->userModel->storePasswordResetToken(
            $user['user_id'],
            $token,
            $expiresAt
        );

        // 🔜 Email sending goes here
        // $resetLink = $request->getUri()->getBasePath() . "/reset-password?token=$token";

        FlashMessage::success(
            "If an account exists, password reset instructions have been sent."
        );

        return $this->showForgotPasswordForm($request, $response, $args);
    }

    public function showProfile (Request $request, Response $response): Response {
        $user = UserContext::getCurrentUser();

        return $this -> render($response, "profileView.php", [$user]);
    }

    public function showWishlist (Request $request, Response $response): Response {
        $user = UserContext::getCurrentUser();

        return $this -> render($response, "wishlistView.php", [$user]);
    }


    // -------------------------------
    // SIGN OUT
    // -------------------------------

    public function logout(Request $request, Response $response, array $args): Response
    {
        UserContext::logout();
        FlashMessage::success("You have been logged out.");
        return $response->withHeader('Location', '/sign-in')->withStatus(302);
    }
}