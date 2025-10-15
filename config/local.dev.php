<?php

declare(strict_types=1);

//Settings for  development (dev) environment

// App-specific config.
define('APP_DEBUG_MODE', true);
define('APP_ASSETS_DIR', '/public/assets');
define('APP_BASE_URL', 'http://localhost/' . APP_ROOT_DIR_NAME);

define('APP_ASSETS_DIR_URL', APP_BASE_URL  . APP_ASSETS_DIR);
define('APP_ASSETS_DIR_PATH', realpath(APP_BASE_DIR_PATH . '/' . APP_ASSETS_DIR));

// Update the cache busting token upon new deployments.
define('CACHE_BUSTING_TOKEN', 'YV954');

function myCustomErrorHandler(int $error_no, string $error_message, string $file, int $line_number)
{
    echo sprintf(
        "<strong>Error:</strong> %s <br><strong>Message:</strong> %s <br> <strong> occurred in:</strong> [%s] <strong> at line:</strong> [%s] <br>",
        getErrorName($error_no),
        $error_message,
        $file,
        $line_number
    );
}

set_error_handler('myCustomErrorHandler');

return function (array $settings): array {
    // Error reporting
    // Enable all error reporting for dev environment.
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');

    $settings['error']['display_error_details'] = true;

    // Database
    $settings['db']['database'] = 'worldcup';
    $settings['db']['hostname'] = 'localhost';
    $settings['db']['port'] = '3306';

    return $settings;
};
