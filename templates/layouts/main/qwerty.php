<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 01.04.2019
 * Time: 22:40
 */
?>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>
        <?=$this->e($title ?? null)?>
    </title>

    <link rel="stylesheet" href="/css/qwerty.css">
    <link rel="stylesheet" href="/css/index.css">


    <script src="/javascript/auth/main.js"></script>

</head>

<body>

    <hr style="size: 6px; width: calc(100%-20px);">

    <h1><?=$this->e($title ?? null)?></h1>

    <hr style="size: 6px; width: calc(100%-20px);">

    <h2><?=$this->e($error ?? null)?></h2>

    <?=$this->section('content')?>

    <center>
        <a style="background-color: #c1c1c1; display: inline-block; padding: 10px;" href="javascript:history.back()">Go Back</a>

        <a style="background-color: #c1c1c1; display: inline-block; padding: 10px;" href="/">Main Page</a>
    </center>

</body>

</html>
