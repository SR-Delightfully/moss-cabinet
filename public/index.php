<?php

declare(strict_types=1);

//* This is the entry point of the application: the front controller of the Slim application.

// Launch the application's bootstrap process.
(require_once realpath(__DIR__ . '/../config/bootstrap.php'))->run();
