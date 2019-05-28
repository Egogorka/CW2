<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/main/mysqlin.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/main/Data.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/users/User.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/lobbies/LobbyManager.php';

use Main\Data;
use User\User;

use Lobby\LobbyManager;

User::$db = $db;

$get = json_decode($_POST["param"], true);

if ($get['type'] === 'create') {
    $res = LobbyManager::create( $_SESSION['clan_id'],  $get['name'], $get['opts'], $get['map'], $get['eventer']);
    return $res;
}

?>