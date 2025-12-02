<?php
namespace App\Helpers;

class LocalizationHelper
{
    private static array $translations = [];
    private static string $lang = 'en';

    public static function setLanguage(string $lang): void
    {
        self::$lang = $lang;
        $file = APP_BASE_DIR_PATH . "/app/Languages/{$lang}.php";
        if (file_exists($file)) {
            self::$translations = require $file;
        } else {
            self::$translations = require APP_ROOT . "/app/Languages/en.php";
        }
    }

    public static function get(string $key): string
    {
        $keys = explode('.', $key);
        $value = self::$translations;

        foreach ($keys as $k) {
            if (!isset($value[$k])) return $key; 
            $value = $value[$k];
        }

        return $value;
    }
}
