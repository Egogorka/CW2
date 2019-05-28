<?php


$container[\Atlas\Pdo\Connection::class] = function (\Psr\Container\ContainerInterface $c) {

    list($dsn, $user, $password) = $c->get('settings')['pdo'];
//    dd($dsn, $user, $password);
    return \Atlas\Pdo\Connection::new($dsn, $user, $password);
};
