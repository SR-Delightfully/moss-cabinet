<?php

declare(strict_types=1);

use App\Middleware\SessionMiddleware;
use App\Middleware\ExceptionMiddleware;
use Slim\App;

return function (App $app) {
    //TODO: Add your middleware here.

    // Add the session middleware to the application (applies to ALL routes)
    $app->add(SessionMiddleware::class);
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();
    //!NOTE: the error handling middleware MUST be added last.
    //!NOTE: You can add override the default error handler with your custom error handler.
    //* For more details, refer to Slim framework's documentation.
    // Add your middleware here.
    // Start the session at the application level.
    //$app->add(SessionStartMiddleware::class);
    $app->add(ExceptionMiddleware::class);
};
