<?php

declare(strict_types=1);
/**
 * Environment-specific application configuration.
 *
 * You should store all secret information (usernames, passwords, tokens,
 * private keys) here.
 *
 */


return function (array $settings): array {
    // Database credentials
    $settings['db']['username'] = 'root';
    $settings['db']['database'] = 'moss_cabinet_db';
    $settings['db']['password'] = '';

    //TODO: Additional settings/configs can be declared here.
    return $settings;
};
