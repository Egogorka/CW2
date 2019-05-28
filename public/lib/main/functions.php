<?php

require_once 'mysqlin.php';

function GetRowByID($id, $table){
    if(!is_int($id)) return NULL;
    global $pdo;
    $sql = "SELECT * FROM ".$table." WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $dbarr = $stmt->fetch(PDO::FETCH_LAZY);
    return $dbarr;
}
