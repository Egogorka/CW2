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
    require_once 'lib/main/mysqlin.php';
    require_once 'lib/main/main.php';

    global $_JSEnable;
    $_JSEnable->enable('lib/main/main.js');

    require_once 'lib/users/userlog/user.php';
    require_once 'lib/clans/clanlog/create.php';

    require_once 'lib/main/functions.php';

    require_once "lib/users/User.php";
    require_once "lib/clans/Clan.php";

    use User\User;
    use Clan\Clan;

    Clan::$db = User::$db = $db;

    //$user = (User::find('id', $_SESSION['id']  ?? null, true));
    //$clan = (Clan::find('id', $_SESSION['clan_id'] ?? null, true));

    ?>

<?php
    // Навбар
    $navInput = "clans";
    require_once 'nav.php';
?>

<!-- Logo </ -->

<div id="logo-contain">
    <img src="images/logo.png" style=" height:calc(100% - 30px); max-width:calc(100% - 30px);">
</div>

<!-- Logo />, Container </ -->

<div id="container">

    <?php
    // Если юзер авторизован - делаем одно, имеет клан - другое, не авторизован - третье
    if($user->isOk())
    {
        if($clan->isOk())
        {
            ?>
            <h1><?php echo $clan->response->name?></h1>
            <center><img src="images/icons/placeholder.png"></center>
            <center><button onclick="win_show('clan_window')">Clan</button></center>
            <?php

            require $_SERVER['DOCUMENT_ROOT'].'/lib/clans/clanmanage/clan.php';
        } else {
            echo "<h2 align='center'>Haven't joined a clan yet? Ask your friends in game or someone in chat, what clan should you choose!</h2>";
        }

    } else {
        echo "<h2 align='center'>Haven't registered yet? Just register and read Q&A to play!</h2>";
    }
        // TODO User's clan description and actions
    ?>

    <hr style="size: 6px; width: calc(100%-20px);">

    <h1 style="text-align: center; color: lightgray; letter-spacing: 0.2em;">Clans</h1>

    <center>
        <div class="search">
            <form>
                <label>SEARCH :<input type="text" style="vertical-align: middle"></label>
                <div class="greenbut button" onclick=""></div>
            </form>
            <div class="vr"></div>
            <img style="vertical-align: middle; height: 1.3em;" src="images/gear.png">
            <div class="vr"></div>
            <a href="#" onclick="win_show('clancr_window')"  class="graybut button">CREATE</a>
            <div class="vr"></div>
            <a href="#" id="clanJBI" class="graybut button">JOIN VIA NAME</a>
        </div>
    </center>

    <?php
    require_once 'lib/userRequests/join.php';

    ?>


    <?php

    $sql = "SELECT * FROM clans";
    $stmt = $db->query($sql);
    while($row = $db->fetch($stmt)){
        $sql = "SELECT * FROM users WHERE id = ?i";
        $leader = $db->getRow($sql, $row['leader_id']);
        echo $row['name'].' : leader -&raquo '.$leader['username'].'<br>';
    }

    ?>

</div>

<!-- Container />, Footer </ -->

<div id="footer">

</div>

</body>

</html>