<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 07.04.2019
 * Time: 13:38
 */

$container[\eduslim\domain\session\SessionDao::class] = function (\Psr\Container\ContainerInterface $c){
    return new \eduslim\domain\session\SessionDao(
        $c->get('logger'),
        $c->get(\Atlas\Pdo\Connection::class)
    );
};

$container[\eduslim\domain\session\SessionManager::class] = function (\Psr\Container\ContainerInterface $c) {
    return new \eduslim\domain\session\SessionManager(
        $c->get('logger'),
        $c->get(\eduslim\domain\session\SessionDao::class),
        $c->get(\eduslim\domain\maps\MapsDao::class)
    );
};