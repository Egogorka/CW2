<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 26.03.2019
 * Time: 12:20
 */

$container[\eduslim\domain\clan\ClansDao::class] = function (\Psr\Container\ContainerInterface $c){
    return new \eduslim\domain\clan\ClansDao(
        $c->get('logger'),
        $c->get(\Atlas\Pdo\Connection::class)
    );
};

$container[\eduslim\domain\clan\ClansManager::class] = function (\Psr\Container\ContainerInterface $c){
    return new \eduslim\domain\clan\ClansManager(
        $c->get('logger'),
        $c->get(\eduslim\domain\user\UserDao::class),
        $c->get(\eduslim\domain\clan\ClansDao::class),
        $c->get(\eduslim\domain\session\SessionDao::class)
    );
};

$container[\eduslim\domain\clan\ClanService::class] = function (\Psr\Container\ContainerInterface $c) {
    return new \eduslim\domain\clan\ClanService(
        $c->get(\eduslim\domain\clan\ClansManager::class),
        $c->get(\eduslim\domain\user\UserManager::class)
    );
};