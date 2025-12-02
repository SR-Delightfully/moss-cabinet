<?php
namespace App\Helpers;

class UserContext
{
    /**
     * Initialize session and default keys
     */
    public static function init(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['currentUser'])) {
            $_SESSION['currentUser'] = null;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    /**
     * Get the current logged-in user
     */
    public static function getCurrentUser(): ?array
    {
        return $_SESSION['currentUser'] ?? null;
    }

    /**
     * Log in a user and set their session data
     */
    public static function login(array $userData): void
    {
        $_SESSION['currentUser'] = [
            'user_username'    => $userData['user_username'] ?? $userData['user_name'] ?? '',
            'user_first_name'  => $userData['user_first_name'] ?? $userData['user_fname'] ?? '',
            'user_last_name'   => $userData['user_last_name'] ?? $userData['user_lname'] ?? '',
            'user_email'       => $userData['user_email'] ?? '',
            'user_pfp_src'     => $userData['user_pfp_src'] ?? null,
            'is_admin'         => $userData['is_admin'] ?? ($userData['user_role'] ?? '') === 'ADMIN',
        ];

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    /**
     * Log out the current user
     */
    public static function logout(): void
    {
        $_SESSION['currentUser'] = null;
        $_SESSION['cart'] = [];
    }

    /**
     * Check if a user is logged in
     */
    public static function isLoggedIn(): bool
    {
        return !empty($_SESSION['currentUser']);
    }

    /**
     * Check if the current user is an admin
     */
    public static function isAdmin(): bool
    {
        $user = self::getCurrentUser();
        return $user && !empty($user['is_admin']);
    }

    /**
     * Add an item to the cart
     */
    public static function addToCart(int $itemId): void
    {
        $_SESSION['cart'][$itemId] = ($_SESSION['cart'][$itemId] ?? 0) + 1;
    }

    /**
     * Remove an item from the cart
     */
    public static function removeFromCart(int $itemId): void
    {
        unset($_SESSION['cart'][$itemId]);
    }

    /**
     * Get the current cart contents
     */
    public static function getCart(): array
    {
        return $_SESSION['cart'] ?? [];
    }
}
