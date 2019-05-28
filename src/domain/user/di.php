<?php

$container[\eduslim\domain\user\UserDao::class] = function (\Psr\Container\ContainerInterface $c){
    return new \eduslim\domain\user\UserDao(
        $c->get('logger'),
        $c->get(\Atlas\Pdo\Connection::class)
    );
};

$container[\eduslim\domain\user\UserManager::class] = function (\Psr\Container\ContainerInterface $c) {
    return new \eduslim\domain\user\UserManager(
        $c->get(\eduslim\domain\user\UserDao::class),
        $c->get(\eduslim\domain\clan\ClansDao::class)
    );
};

$container[\eduslim\domain\user\AuthManager::class] = function (\Psr\Container\ContainerInterface $c) {
    return new \eduslim\domain\user\AuthManager(
        $c->get('logger'),
        $c->get(\eduslim\domain\user\UserManager::class)
    );
};
