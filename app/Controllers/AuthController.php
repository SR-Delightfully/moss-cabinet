<?php

declare(strict_types=1);

namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Models\UserModel;
use App\Helpers\FlashMessage;
use App\Helpers\SignupHelper;
use App\Helpers\SmsHelper;
use App\Helpers\SessionManager;
use App\Helpers\UserContext;

class AuthController extends BaseController
{
    private UserModel $user_model;
    public function __construct(
        Container $container,
    private UserModel $userModel,
    private SmsHelper $smsHelper
    )
    {
        parent:: __construct($container);
        $this->user_model=$user_model;
    }

    public function showLoginForm(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'pages/loginView.php');
    }

    public function login(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $isValid = true;

        //email validation
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            FlashMessage::error("Email invalid format");
            $isValid = false;
        }

        //if password is shorter than 8 chars
        if (!preg_match('/^.{8,}$/', $data['password'])) {
            FlashMessage::error("Password must be 8 characters long");
            $isValid = false;
        }

        //if validation is correct then check if the user exists/login
        if ($isValid) {
            $user = $this->userModel->login($data['email'], $data['password']);
            //if login is correct then redirect to 2fa
            if ($user) {
                $phone = $user['phone'];
                $phoneFormat = '+1' . $phone;

                $sms = new SmsHelper();
                $sent = $sms->sendVerificationCode($phoneFormat);

                if (!$sent) {
                    FlashMessage::error("Failed to send SMS message");
                    return $this->render($response, 'pages/loginView.php');
                }

                SessionManager::set('pending_2fa', [
                    'user'       => $user,
                    'phone'      => $phoneFormat,
                ]);

                $render = [
                    'show2fa' => true,
                ];
                return $this->render($response, 'pages/loginView.php', $render);
            } else {
                //else display flash message and render same page
                FlashMessage::error("Incorrect Credentials");
                return $this->render($response, 'pages/loginView.php');
            }
        } else {
            //else data is not valid render same page and display flash messages
            return $this->render($response, 'pages/loginView.php');
        }
    }

    public function showSignupForm(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'pages/signupView.php');
    }

    public function signup(Request $request, Response $response, array $args): Response {
        //get data from form
        $data = $request->getParsedBody();
        $isValid = true;

        //validate for empty fields
        if (empty($data['first_name'] || $data['last_name'] || $data['email'] || $data['phone']
            || $data['password'] || $data['conf_password'])) {
            FlashMessage::error("Fill Out All Fields");
            $isValid = false;
        }
        //validate for only letters
        if (!preg_match('/^[\p{L}\s\'-]+$/u', $data['first_name']) || !preg_match('/^[\p{L}\s\'-]+$/u', $data['last_name'])) {
            FlashMessage::error("First and Last name must be Letters only");
            $isValid = false;
        }
        //if phone number is only numbers
        if (!is_numeric($data['phone'])) {
            FlashMessage::error("Phone number must only contain numbers");
            $isValid = false;
        }
        //if phone number is 10 digits
        if (!preg_match('/^[0-9]{10}$/', $data['phone'])) {
            FlashMessage::error("Phone number must be 10 digits");
            $isValid = false;
        }
        //if email follows email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            FlashMessage::error("Email invalid format");
            $isValid = false;
        }
        //if password and confirmation password match
        if (true) {
            FlashMessage::error("Password and Confirm Password Do Not Match");
            $isValid = false;
        }

        //if password is less than 8 characters
        if (!preg_match('/^.{8,}$/', $data['password'])) {
            FlashMessage::error("Password must be 8 characters long");
            $isValid = false;
        }


        //if isvalid render 2fa Page or just render signIn page
        if ($isValid) {
            return $this->render($response, 'auths/signinView.php');
        } else {
            //else render page again with flash messages
            return $this->render($response, 'auth/signupView.php');
        }
    }

    public function verifyTwoFactor(Request $request, Response $response, array $args): Response {
        //get inputted code from post form
        $data = $request->getParsedBody();
        $code = trim($data['code'] ?? '');

        $pending = SessionManager::get('pending_2fa');

        if (!$pending || empty($pending['user']) || empty($pending['phone'])) {
            FlashMessage::error("2FA Session Expired. Please try to log in again in a minute.");
            SessionManager::remove('pending_2fa');
            return $this->render($response, 'auth/signinView.php');
        }

        $phoneFormat = $pending['phone'];

        try {
        $sms = new SmsHelper();

        $ok = $sms->checkVerificationCode($phoneFormat, $code);

        //if code is incorrect
        if (!$ok) {
            FlashMessage::error("Invalid or expired verification code.");
            return $this->render($response, 'auth/signinView.php', ['show2fa' => true]);
        }

        //2fa code is correct
        $user = $pending['user'];

        unset($_SESSION['pending_2fa']);

        UserContext::login($user);

        return $this->render($response, '/homeView.php');

    } catch (\Throwable $e) {
        error_log("2FA verify error: " . $e->getMessage());
        FlashMessage::error("There was a problem verifying your code. Try again.");

        $render = [
            'show2fa' => true,
        ];

        return $this->render($response, 'auth/signinView.php', $render);
        }
    }

    public function showForgotPasswordForm(Request $request, Response $response, array $args): Response {
        $render = [
            'show_forgot_password' => true,
        ];
        return $this->render($response, 'auth/signinView.php', $render);
    }

    public function sendForgotPassword(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();
        $render = [
            'show_forgot_password' => true,
        ];

        if (!preg_match('/^[0-9]{10}$/', $data['phone'])) {
            FlashMessage::error("Phone number must be 10 digits");
            return $this->render($response, 'auth/signinView.php', $render);
        } else {
            $user = $this->userModel->getUserByPhone($data['phone']);

            if ($user) {
                //TODO SEND_VERIFICATION_CODE_HERE
                return $this->render($response, 'auth/signinView.php', $render);
            }

            return $this->render($response, 'auth/signinView.php', $render);
        }
    }

    public function verifyForgotPassword(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'auth/signinView.php');
    }

    public function showNewPasswordForm(Request $request, Response $response, array $args): Response {
        $render = [
            'show_new_password' => true,
        ];

        return $this->render($response, 'auth/signinView.php');
    }

    public function verifyNewPassword(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'auth/signinView.php');
    }

    public function showForgotEmail(Request $request, Response $response, array $args): Response {
        $render = [
            'show_forgot_email' => true,
        ];

        return $this->render($response, 'auth/signinView.php', $render);
    }
    public function verifyForgotEmail(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'auth/signinView.php');
    }

    public function showNewEmail(Request $request, Response $response, array $args): Response {
        $render = [
            'show_new_email' => true,
        ];

        return $this->render($response, 'auth/signinView.php', $render);
    }
    public function verifyNewEmail(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'auth/signinView.php');
    }

    public function logout(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'auth/signinView.php');
    }
}

?>
