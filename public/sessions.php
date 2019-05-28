<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="lib/windows/win.css">
    <link rel="stylesheet" href="style_.css">
    <link rel="stylesheet" href="lib/users/userlog/user.css">
</head>
<body>

<?php
    require 'lib/main/main.php';

    global $_JSEnable;
    $_JSEnable->enable('lib/main/main.js');

    require 'lib/users/userlog/user.php';

    $navInput = "sessions";
    require 'nav.php';

    require_once "lib/lobbies/LobbyManager.php";
    require_once "lib/sessions/SessionsManager.php";

    use Sessions\SessionsManager;
    use Lobby\LobbyManager;

?>

<!-- Logo </ -->

<div id="logo-contain">
    <img src="images/logo.png" style=" height:calc(100% - 30px); max-width:calc(100% - 30px);">
</div>

<!-- Logo />, Container </ -->

<div id="container">




    <hr style="size: 6px; width: calc(100%-20px);">

    <h1 style="text-align: center; color: lightgray; letter-spacing: 0.2em;">Sessions</h1>

    <?php

    SessionsManager::searchBar();

    //SessionsManager::sessionList();

    LobbyManager::showCreation();

    ?>

</div>

<!-- Container />, Footer </ -->

<div id="footer">

</div>

</body>

</html>