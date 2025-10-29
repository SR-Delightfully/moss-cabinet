<?php

namespace App\Helpers;

class SessionManager
{
    /**
     * Start the session with secure configuration.
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {

            // Configure session to last 1 day (good for local development)
            $sessionLifetime = 24 * 60 * 60; // (hours * minutes * seconds) -> 1 day in seconds -> 86400 seconds

            // Set session cookie parameters
            session_set_cookie_params([
                'lifetime' => $sessionLifetime,
                'path' => '/',
                'domain' => '',
                'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
                'httponly' => true,
                'samesite' => 'Strict'
            ]);

            // Configure garbage collection (automatic cleanup)
            ini_set('session.gc_maxlifetime', $sessionLifetime);
            ini_set('session.gc_probability', 1);
            ini_set('session.gc_divisor', 100);

            // Security settings
            ini_set('session.use_strict_mode', 1);
            ini_set('session.cookie_httponly', 1);

            session_start();

            // Regenerate session ID every 15 minutes for security
            if (!isset($_SESSION['last_regeneration'])) {
                $_SESSION['last_regeneration'] = time();
                session_regenerate_id(true);
            } elseif (time() - $_SESSION['last_regeneration'] > 900) {
                $_SESSION['last_regeneration'] = time();
                session_regenerate_id(true);
            }

            // Browser fingerprinting for security (detect session hijacking)
            $fingerprint = self::generateFingerprint();
            if (!isset($_SESSION['fingerprint'])) {
                $_SESSION['fingerprint'] = $fingerprint;
            } elseif ($_SESSION['fingerprint'] !== $fingerprint) {
                // Different browser detected - destroy and restart session
                session_destroy();
                session_start();
                $_SESSION['fingerprint'] = $fingerprint;
                $_SESSION['last_regeneration'] = time();
            }
        }
    }

    /**
     * Generate a unique browser fingerprint for security.
     */
    private static function generateFingerprint(): string
    {
        $factors = [
            $_SERVER['HTTP_USER_AGENT'] ?? '',
            $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '',
            $_SERVER['HTTP_ACCEPT_ENCODING'] ?? '',
            $_SERVER['REMOTE_ADDR'] ?? ''
        ];

        return hash('sha256', implode('|', $factors));
    }

    /**
     * Store a value in the session.
     */
    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Retrieve a value from the session.
     */
    public static function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Check if a key exists in the session.
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Remove a key from the session.
     */
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Clear all session data.
     */
    public static function clear(): void
    {
        session_unset();
    }

    /**
     * Destroy the session completely.
     */
    public static function destroy(): void
    {
        session_destroy();
    }
}
