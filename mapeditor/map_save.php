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
use Main\Data\Data;

if (!is_null($_SESSION['id'] or null)) {

    $get = json_decode($_POST["param"], true);

    $user = new User();
    $res = $user->find('id', $_SESSION['id']);

    $map = new Map();

    $map->setDb($db);
    $map->setName($get['name']);
    $map->setCreator($user);

    $map->StrToMap($get['map']);

    $map->save();
    //$map->draw();

} else return new Data([
    'errCode' => '400',
    'errText' => 'Not authorized',
]);