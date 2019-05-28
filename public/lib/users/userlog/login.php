<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/lib/main/mysqlin.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/lib/main/Data.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/lib/users/User.php';

    use Main\Data;
    use User\User;

    User::$db = $db;

    $get = json_decode($_POST["param"], true);

    if ($get['type'] == 'login') {

        $res  = new Data();

        $tmp  = User::find('username', $get['login'], true);
        $user = $tmp->response;

        $res->changeBy($tmp);
        $res->changeBy($user->pass($get['pass']));

        $_SESSION['id'] = $user->getId();
        $_SESSION['clan_id'] = $user->getClanID();

        echo json_encode($res->toArray());
    } else {

        $user = new User();
        $res = $user->create($get['login'], $get['pass'],$get['email'] );

        $_SESSION['id'] = $user->getId();

        echo json_encode($res->toArray());
    }

?>