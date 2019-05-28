<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/lib/main/mysqlin.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/main/Data.php';

$get = json_decode($_POST["param"], true);

$get = array_merge([
    'name' => null,
    'type' => null,
], $get);

$get = json_decode(json_encode($get));

do {
    if (empty($_SESSION['id'])) {
        $out = new Data([
            'errText' => 'Unauthorized',
            'errCode' => 400,
        ]);
        break;
    }

    $user = $db->getRow('SELECT * FROM users WHERE id=?i', $_SESSION['id']);
    if (!$user){
        $out = new Data([
            'errText' => 'Your id is wrong, no such user',
            'errCode' => 400,
        ]);
        break;
    }

    if (!empty($user['clan_id'])) {
        $out = new Data([
            'errText' => 'No clan name to add',
            'errCode' => 401,
        ]);
        break;
    }

    $res = $db->getRow("SELECT * FROM clans WHERE name = ?s", $get->name);
    if ($res) {
        $out = new Data([
            'errText' => 'Clan with that name already exists',
            'errCode' => 501,
        ]);
        break;
    }

// TODO Testing clan id's and other stuff

    $res = $db->query("INSERT INTO clans (name, leaderId) VALUES (?s, ?i)", $get->name, $_SESSION['id']);
    $id = $db->insertId();
    $res = $db->query('UPDATE users SET clanId = ?i WHERE id = ?i', $id, $user['id']);

}while(false);
echo "Everything ok, clan created";