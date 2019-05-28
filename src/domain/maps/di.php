<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 25.03.2019
 * Time: 18:24
 */

$container[\eduslim\domain\maps\MapsManager::class] = function (\Psr\Container\ContainerInterface $c) {
    return new \eduslim\domain\maps\MapsManager(
        $c->get('logger'),
        $c->get(\Atlas\Pdo\Connection::class)
    );
};