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

    // Optional extras mirroring your React logic
    public static function addToCart(int $itemId): void
    {
        $_SESSION['cart'][$itemId] = ($_SESSION['cart'][$itemId] ?? 0) + 1;
    }

    public static function removeFromCart(int $itemId): void
    {
        unset($_SESSION['cart'][$itemId]);
    }

    public static function getCart(): array
    {
        return $_SESSION['cart'] ?? [];
    }
}
