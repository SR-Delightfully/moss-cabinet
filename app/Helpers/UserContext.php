<?php
namespace App\Helpers;

class UserContext
{
    public static function init(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['currentUser'])) {
            $_SESSION['currentUser'] = null;
        }
    }

    public static function getCurrentUser(): ?array
    {
        return $_SESSION['currentUser'] ?? null;
    }

    public static function login(array $userData): void
    {
        $userData['user_role'] = $userData['user_role'] ?? 'customer';
        $_SESSION['currentUser'] = $userData;
    }

    public static function logout(): void
    {
        unset($_SESSION['currentUser']);
    }

    public static function isLoggedIn(): bool
    {
        return !empty($_SESSION['currentUser']);
    }

    public static function getRole(): ?string
    {
        return $_SESSION['currentUser']['user_role'] ?? null;
    }

    public static function isAdmin(): bool
    {
        return self::getRole() === 'admin';
    }

    public static function isCustomer(): bool
    {
        return self::getRole() === 'customer';
    }
}
