<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Models\TwoFactorAuthModel;
use App\Domain\Models\TrustedDeviceModel;
use App\Domain\Models\UserModel;
use App\Helpers\FlashMessage;
use App\Helpers\SessionManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use RobThree\Auth\Providers\Qr\BaconQrCodeProvider;
use RobThree\Auth\TwoFactorAuth;

class TwoFactorController extends BaseController
{
    private const APP_NAME = 'book-shop';

    public function __construct(
        ContainerInterface $container,
        private TwoFactorAuthModel $twoFactorModel,
        private UserModel $userModel,
        private TrustedDeviceModel $trustedDeviceModel
    ) {
        parent::__construct($container);
    }


    public function showSetup(Request $request, Response $response): Response
    {
        $userId = SessionManager::get('user_id');
        $email  = SessionManager::get('user_email');

        if ($this->twoFactorModel->isEnabled($userId)) {
            FlashMessage::add('error', '2FA already enabled.');
            return $this->redirectAfterAuth($request, $response);
        }

        $tfa    = $this->makeTfa();
        $secret = $tfa->createSecret();

        SessionManager::set('2fa_setup_secret', $secret);

        return $this->render($response, 'auth/2fa-setup.php', [
            'title' => 'Enable 2FA',
            'qrCodeDataUri' => $tfa->getQRCodeImageAsDataUri($email, $secret),
            'secret' => $secret,
        ]);
    }

    public function verifyAndEnable(Request $request, Response $response): Response
    {
        $userId = SessionManager::get('user_id');
        $email  = SessionManager::get('user_email');
        $code   = $request->getParsedBody()['code'] ?? '';
        $secret = SessionManager::get('2fa_setup_secret');

        if (!$secret) {
            FlashMessage::add('error', '2FA setup expired.');
            return $this->redirect($request, $response, '2fa.setup');
        }

        $tfa = $this->makeTfa();

        if (!$tfa->verifyCode($secret, $code)) {
            return $this->render($response, 'auth/2fa-setup.php', [
                'title' => 'Enable 2FA',
                'error' => 'Invalid code.',
                'qrCodeDataUri' => $tfa->getQRCodeImageAsDataUri($email, $secret),
                'secret' => $secret,
            ]);
        }

        $this->twoFactorModel->create($userId, $secret);
        $this->twoFactorModel->enable($userId);

        SessionManager::remove('2fa_setup_secret');
        FlashMessage::add('success', '2FA enabled.');

        return $this->redirectAfterAuth($request, $response);
    }

    /* ================= LOGIN VERIFY ================= */

    public function showVerify(Request $request, Response $response): Response
    {
        return $this->render($response, 'auth/2fa-verify.php', [
            'title' => 'Verify 2FA',
        ]);
    }

    public function verify(Request $request, Response $response): Response
    {
        $userId = SessionManager::get('user_id');
        $code   = $request->getParsedBody()['code'] ?? '';
        $secret = $this->twoFactorModel->getSecret($userId);

        $tfa = $this->makeTfa();

        if (!$tfa->verifyCode($secret, $code)) {
            $attempts = (SessionManager::get('2fa_attempts') ?? 0) + 1;
            SessionManager::set('2fa_attempts', $attempts);

            if ($attempts >= 5) {
                SessionManager::destroy();
                return $this->redirect($request, $response, 'auth.login');
            }

            return $this->render($response, 'auth/2fa-verify.php', [
                'title' => 'Verify 2FA',
                'error' => 'Invalid code.',
            ]);
        }

        SessionManager::remove('2fa_attempts');
        SessionManager::set('two_factor_verified', true);
        session_regenerate_id(true);

        if (!empty($request->getParsedBody()['trust_device'])) {
            $this->trustDevice($request, $userId);
        }

        return $this->redirectAfterAuth($request, $response);
    }

    public function showDisable(Request $request, Response $response): Response
    {
        return $this->render($response, 'auth/2fa-disable.php', [
            'title' => 'Disable 2FA',
        ]);
    }

    public function disable(Request $request, Response $response): Response
    {
        $email    = SessionManager::get('user_email');
        $userId   = SessionManager::get('user_id');
        $password = $request->getParsedBody()['password'] ?? '';

        if (!$this->userModel->verifyCredentials($email, $password)) {
            return $this->render($response, 'auth/2fa-disable.php', [
                'title' => 'Disable 2FA',
                'error' => 'Invalid password.',
            ]);
        }

        $this->twoFactorModel->disable($userId);
        FlashMessage::add('success', '2FA disabled.');

        return $this->redirectAfterAuth($request, $response);
    }

    private function makeTfa(): TwoFactorAuth
    {
        return new TwoFactorAuth(
            new BaconQrCodeProvider(4, '#fff', '#000', 'svg'),
            self::APP_NAME
        );
    }

    private function trustDevice(Request $request, int $userId): void
    {
        $token     = bin2hex(random_bytes(32));
        $expiresAt = (new \DateTime('+30 days'))->format('Y-m-d H:i:s');

        $this->trustedDeviceModel->create($userId, $token, [
            'device_name' => $this->getDeviceName($request),
            'user_agent'  => $request->getHeaderLine('User-Agent'),
            'ip_address'  => $this->getClientIp($request),
            'expires_at'  => $expiresAt,
        ]);

        setcookie('trusted_device', $token, [
            'expires'  => strtotime('+30 days'),
            'path'     => '/' . APP_ROOT_DIR_NAME,
            'secure'   => false, 
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }

    private function redirectAfterAuth(Request $request, Response $response): Response
    {
        return SessionManager::get('user_role') === 'ADMIN'
            ? $this->redirect($request, $response, 'dashboard.index')
            : $this->redirect($request, $response, 'user.dashboard');
    }

    private function getDeviceName(Request $request): string
    {
        $ua = $request->getHeaderLine('User-Agent');

        return match (true) {
            stripos($ua, 'Windows') !== false => 'Windows PC',
            stripos($ua, 'Mac') !== false => 'Mac',
            stripos($ua, 'iPhone') !== false => 'iPhone',
            stripos($ua, 'Android') !== false => 'Android',
            stripos($ua, 'Linux') !== false => 'Linux PC',
            default => 'Unknown Device',
        };
    }

    private function getClientIp(Request $request): string
    {
        $params = $request->getServerParams();

        if (!empty($params['HTTP_X_FORWARDED_FOR'])) {
            return trim(explode(',', $params['HTTP_X_FORWARDED_FOR'])[0]);
        }

        return $params['REMOTE_ADDR'] ?? '0.0.0.0';
    }
}
