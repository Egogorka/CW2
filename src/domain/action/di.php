<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 07.04.2019
 * Time: 14:49
 */

$container[\eduslim\domain\action\ActionDao::class] = function (\Psr\Container\ContainerInterface $c) {
    return new \eduslim\domain\action\ActionDao(
        $c->get('logger'),
        $c->get(\Atlas\Pdo\Connection::class)
    );
};

$container[\eduslim\domain\action\ActionManager::class] = function (\Psr\Container\ContainerInterface $c) {
    return new \eduslim\domain\action\ActionManager(
        $c->get('logger'),
        $c->get(\eduslim\domain\action\ActionDao::class)
    );
};