<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 23.01.2019
 * Time: 22:31
 */

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/main/mysqlin.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/users/User.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mapeditor/Map.php';

global $db;

use Map\Map;
use Main\Data;
use User\User;

User::$db = $db;

do {

    if (is_null($_SESSION['id'] or null)) {
        $out = new Data([
            'errCode' => '400',
            'errText' => 'Not authorized',
        ]);
        break;
    }

    $get = json_decode($_POST["param"], true);

    $res = User::find('id', $_SESSION['id'], true);

    if (!$res->isOk()) {
        $out = new Data([
            'errCode' => '404',
            'errText' => 'No player with your id. Please ask administrator about this problem',
        ]);
        break;
    }

    $map = new Map();

    $map->setDb($db);
    $map->setName($get['name']);
    $map->setCreator($res->response);

    $map->StrToMap($get['map']);

    $map->save();
    $map->draw();

    $out = new Data;

} while (false);

echo json_encode($out->toArray());

