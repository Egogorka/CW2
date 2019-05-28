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
    require_once 'lib/main/mysqlin.php';

    global $_JSEnable;
    $_JSEnable->enable('lib/main/main.js');

    require 'lib/users/userlog/user.php';

    $navInput = "maps";
    require 'nav.php';
?>

<!--  Logo </ -->

<div id="logo-contain">
    <img src="images/logo.png" style=" height:calc(100% - 30px); max-width:calc(100% - 30px);">
</div>

<!-- Logo />, Container </ -->

<div id="container">

    <h1 style="text-align: center; color: lightgray; letter-spacing: 0.2em;">Maps</h1>

    <?php
    require "mapeditor/MapView.php";

    use Map\MapView;

    MapView::searchBar();

    MapView::mapList();

    ?>



</div>

<!-- Container />, Footer </ -->

<div id="footer">

</div>

</body>

</html>


