<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/lib/main/mysqlin.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/main/Data.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/userRequests/userRequests.php';

$uRequest = new UserRequests($db);

$get = json_decode($_POST["param"], true);
$defaults = [
    'clanName' => null,
];
$get = array_merge($defaults , $get);

$out = $uRequest->create($_SESSION['id'], $get['clanName']);

echo json_encode($out->toArray());