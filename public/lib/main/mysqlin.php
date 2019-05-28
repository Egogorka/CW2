<?php

/*
$host       = 'localhost';
$db         = 'db_erem';
$user       = 'erem';
$password   = '2877dc';
$charset    = 'utf8';

$dsn = 'mysql:host='.$host.';dbname='.$db.';charset='.$charset;

$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::ATTR_PERSISTENT         => true, // Для постоянного подключения
];

$pdo = new PDO($dsn, $user, $password, $opt);

function pdoSet($allowed, &$values, $source = array()) {
    $set = '';
    $values = array();
    if (!$source) $source = &$_POST;
    foreach ($allowed as $field) {
        if (isset($source[$field])) {
            $set.="`".str_replace("`","``",$field)."`". "=:$field, ";
            $values[$field] = $source[$field];
        }
    }
    return substr($set, 0, -2);
}
*/

require $_SERVER['DOCUMENT_ROOT'].'/lib/main/SecurityDB.php';

$opts = array(
    'host'      => 'localhost',
    'user'      => 'erem',
 	'pass'      => '2877dc',
 	'db'        => 'db_erem',
 	'charset'   => 'utf8'
);

$db = new eSafeMySQL($opts);

