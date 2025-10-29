<?php

namespace App\Helpers;

class FlashMessage
{
    private const FLASH_KEY = 'flash_messages';

    public static function success(string $msg): void
    {
        self::add('success', $msg);
    }

    public static function error(string $msg): void
    {
        self::add('error', $msg);
    }

    public static function info(string $msg): void
    {
        self::add('info', $msg);
    }

    public static function warning(string $msg): void
    {
        self::add('warning', $msg);
    }

    public static function add(string $type, string $msg): void
    {
        if (!isset($_SESSION[self::FLASH_KEY])) {
            $_SESSION[self::FLASH_KEY] = [];
        }

        $_SESSION[self::FLASH_KEY][] = [
            'type' => $type,
            'msg' => $msg
        ];
    }

    public static function get(): array
    {
        $msg = $_SESSION[self::FLASH_KEY] ?? [];
        unset($_SESSION[self::FLASH_KEY]);
        return $msg;
    }

    public static function has(): bool
    {
        return !empty($_SESSION[self::FLASH_KEY]);
    }

    public static function clear(): void
    {
        unset($_SESSION[self::FLASH_KEY]);
    }

    public static function render(bool $dismissible = true): string
    {
        $msg = self::get();
        if (empty($msg)) {
            return '';
        }

        $bootstrapTypes = [
            'success' => 'success',
            'error' => 'danger',
            'info' => 'info',
            'warning' => 'warning'
        ];

        $html = '';
        foreach ($msg as $flash) {
            $type = $bootstrapTypes[$flash['type']] ?? 'info';
            $msg = htmlspecialchars($flash['msg']);

            if ($dismissible) {
                $html .= <<<HTML
                <div class="alert alert-{$type} alert-dismissible fade show" role="alert">{$msg} <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                HTML;
            } else {
                $html .= <<<HTML
                <div class="alert alert-{$type}" role="alert">{$msg}</div>
                HTML;
            }
        }
        return $html;
    }
}
