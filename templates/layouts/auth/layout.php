<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 23.03.2019
 * Time: 16:55
 */
?>

<html>

<head>

    <meta charset="UTF-8">

    <title>
        <?="Hello";?>
    </title>

    <link rel="stylesheet" href="/css/index.css">

    <script src="/javascript/auth/main.js"></script>

</head>

<body>

    <hr style="size: 6px; width: calc(100%-20px);">

    <h1> Authentication </h1>

    <hr style="size: 6px; width: calc(100%-20px);">

    <h2><?=$this->e($error ?? null)?></h2>

    <?=$this->section('content')?>

</body>

</html>