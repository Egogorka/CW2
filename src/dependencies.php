<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function (\Psr\Container\ContainerInterface $c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ( \Psr\Container\ContainerInterface $c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['view-slim'] = function (\Psr\Container\ContainerInterface $c) {
    $view = new \Projek\Slim\Plates($c->get('settings')['view']);

    // Set \Psr\Http\Message\ResponseInterface object
    // Or you can optionaly pass `$c->get('response')` in `__construct` second parameter
    $view->setResponse($c->get('response'));

    // Instantiate and add Slim specific extension
    $view->loadExtension(new Projek\Slim\PlatesExtension(
        $c->get('router'),
        $c->get('request')->getUri()
    ));

    return $view;
};

//new \Projek\Slim\PlatesProvider();

require __DIR__ . '/domain/Exceptions.php';

require __DIR__ . '/infrastructure/di.php'; // Внешние приложения(?)

require __DIR__ . '/domain/user/di.php';
require __DIR__ . '/domain/maps/di.php';
require __DIR__ . '/domain/clan/di.php';
require __DIR__ . '/domain/session/di.php';

require __DIR__ . '/application/di.php';
