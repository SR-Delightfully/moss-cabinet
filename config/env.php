<?php

declare(strict_types=1);

return function (array $settings): array {
    // Database credentials for moss-cabinet
    $settings['db']['host'] = 'localhost';
    $settings['db']['port'] = 3306;
    $settings['db']['username'] = 'root';
    $settings['db']['database'] = 'moss_cabinet_db';
    $settings['db']['password'] = 'password';
    $settings['db']['charset'] = 'utf8mb4';
    $settings['db']['collation'] = 'utf8mb4_unicode_ci';

    // Add any other settings here

    return $settings;
};
