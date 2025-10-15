<?php

declare(strict_types=1);

use App\Helpers\Core\AppSettings;
use App\Helpers\Core\JsonRenderer;
use App\Helpers\Core\PDOService;
use App\Middleware\ExceptionMiddleware;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Slim\Factory\AppFactory;
use Slim\App;
use Slim\Views\PhpRenderer;

$definitions = [
    AppSettings::class => function () {
        return new AppSettings(
            require_once __DIR__ . '/settings.php'
        );
    },
    App::class => function (ContainerInterface $container) {

        $app = AppFactory::createFromContainer($container);
        // echo APP_ROOT_DIR_NAME;exit;
        $app->setBasePath('/' . APP_ROOT_DIR_NAME);

        // Register web routes.
        (require_once realpath(__DIR__ . '/../app/Routes/web-routes.php'))($app);
        //TODO: We will add it back later (register API routes).
        //(require_once realpath(__DIR__ . '/../app/Routes/api-routes.php'))($app);

        // Register middleware
        (require_once realpath(__DIR__ . '/middleware.php'))($app);

        return $app;
    },
    PhpRenderer::class => function (ContainerInterface $container): PhpRenderer {
        $renderer = new PhpRenderer(APP_VIEWS_PATH);
        return $renderer;
    },
    PDOService::class => function (ContainerInterface $container): PDOService {
        $db_config = $container->get(AppSettings::class)->get('db');
        return new PDOService($db_config);
    },

    // HTTP factories
    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(Psr17Factory::class);
    },
    ServerRequestFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(Psr17Factory::class);
    },
    StreamFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(Psr17Factory::class);
    },
    UriFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(Psr17Factory::class);
    },

    // LoggerInterface::class => function (ContainerInterface $container) {
    //     $settings = $container->get('settings')['logger'];
    //     $logger = new Logger('app');

    //     $filename = sprintf('%s/app.log', $settings['path']);
    //     $level = $settings['level'];
    //     $rotatingFileHandler = new RotatingFileHandler($filename, 0, $level, true, 0777);
    //     $rotatingFileHandler->setFormatter(new LineFormatter(null, null, false, true));
    //     $logger->pushHandler($rotatingFileHandler);

    //     return $logger;
    // },
    ExceptionMiddleware::class => function (ContainerInterface $container) {
        $settings = $container->get(AppSettings::class)->get('error');
        return new ExceptionMiddleware(
            $container->get(ResponseFactoryInterface::class),
            $container->get(JsonRenderer::class),
            null,
            (bool) $settings['display_error_details'],
        );
    },
];
return $definitions;
