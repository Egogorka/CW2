<?php


$container[\eduslim\application\controller\DemoController::class] = function (\Psr\Container\ContainerInterface $c) {
    return new \eduslim\application\controller\DemoController(
        $c->get('logger'),
        $c->get('view-slim'),
        $c->get(\eduslim\domain\user\UserManager::class)
    );
};

$container[\eduslim\application\controller\AuthController::class] = function (\Psr\Container\ContainerInterface $c) {
    return new \eduslim\application\controller\AuthController(
        $c->get('logger'),
        $c->get('view-slim'),
        $c->get(\eduslim\domain\user\AuthManager::class)
    );
};

$container[\eduslim\application\controller\IntroController::class] = function (\Psr\Container\ContainerInterface $c) {
    return new \eduslim\application\controller\IntroController(
        $c->get('logger'),
        $c->get('view-slim')
    );
};

$container[\eduslim\application\controller\MapsController::class] = function (\Psr\Container\ContainerInterface $c) {
    return new \eduslim\application\controller\MapsController(
        $c->get('logger'),
        $c->get('view-slim'),
        $c->get(\eduslim\domain\maps\MapsManager::class)
    );
};

$container[\eduslim\application\controller\ClansController::class] = function (\Psr\Container\ContainerInterface $c) {
    return new \eduslim\application\controller\ClansController(
        $c->get('logger'),
        $c->get('view-slim'),
        $c->get(\eduslim\domain\clan\ClansManager::class),
        $c->get(\eduslim\domain\user\UserManager::class)
    );
};

$container[\eduslim\application\controller\ClanController::class] = function (\Psr\Container\ContainerInterface $c) {
    return new \eduslim\application\controller\ClanController(
        $c->get('logger'),
        $c->get('view-slim'),
        $c->get(\eduslim\domain\clan\ClansManager::class),
        $c->get(\eduslim\domain\user\UserManager::class),
        $c->get(\eduslim\domain\maps\MapsManager::class),
        $c->get(\eduslim\domain\clan\ClanService::class)
    );
};

$container[\eduslim\application\controller\SessionController::class] = function (\Psr\Container\ContainerInterface $c) {
    return new \eduslim\application\controller\SessionController(
        $c->get('logger'),
        $c->get('view-slim'),
        $c->get(\eduslim\domain\user\UserManager::class),
        $c->get(\eduslim\domain\clan\ClansManager::class),
        $c->get(\eduslim\domain\session\SessionManager::class)
    );
};

$container[\eduslim\application\controller\SocketController::class] = function (\Psr\Container\ContainerInterface $c) {
    return new \eduslim\application\controller\SocketController(
        $c->get(\eduslim\domain\session\SessionManager::class),
        $c->get(\eduslim\domain\clan\ClansManager::class),
        $c->get(\eduslim\domain\user\UserManager::class)
    );
};

//