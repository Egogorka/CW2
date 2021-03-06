<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="/style_.css">
    <link rel="stylesheet" href="lib/windows/win.css">
    <link rel="stylesheet" href="lib/users/userlog/user.css">
</head>
<body>

<?php
    require 'lib/main/main.php';

    global $_JSEnable;
    $_JSEnable->enable('lib/main/main.js');

    require 'lib/users/userlog/user.php';

    $navInput = "main";
    require 'nav.php';
?>

<!-- Logo </ -->

<div id="logo-contain">
    <img src="images/logo.png" style=" height:calc(100% - 30px); max-width:calc(100% - 30px);">
</div>

<!-- Logo />, Container </ -->

<div id="container">
    <h1 style="text-align: center; color: lightgray; letter-spacing: 0.2em;">About</h1>

    <hr style="size: 6px; width: calc(100%-20px);">

    <p><b>ClanWars - мультипользовательская стратегическая игра</b>, в которой игроки - кланы, а в кланах уже вы.</p>
    <p>Процесс игры называется <a href="sessions.php">сессией</a>, которая происходит на какой-либо <a href="maps.php"> карте </a>, которую можно сделать самому или взять уже существующую.</p>

    <p> Процесс игры разделяется на несколько <em>фаз</em>, повторяющиеся друг за другом до исхода (вкупе один обход цикла фаз - это ход), а именно: </p>
    <ul>
        <li>
            <b>Планирование</b> : во время этой фазы каждый член клана, находящийся в игре, может спланировать атаку на <em>сектор</em>,
            прилегающий к территории клана. Также, во время этой фазы клан может делать другие действия, не относящиеся к военным,
            например <em> распределение бюджета </em> и <em> построение конструкций </em>
        </li>
        <li>
            <b>Фаза инициации</b> : в течение этой фазы клан может видеть спланированные атаки на них и атаки, спланированные кланом,
            не могут быть отменены. На каждый атакованный сектор создаётся <em> лобби </em>.
            <em> Сражение </em> начинается если лобби заполняется полностью.
        </li>
        <li>
            <b> Фаза сражений</b> : во начале этой фазы начинается каждое сражение в каждом лобби, если оно уже не началось.
            В конце фазы все сражения будут остановлены.
        </li>
        <li>
            <b> Конечная фаза</b> : по приходу этой фазы результаты всех законченных, или <em>остановленных</em> боёв будут выведены.
            Также в <em>бюджет клана/игроков</em> придут деньги с секторов в их распоряжении.
        </li>
        <b> Сектора</b> - это те шестиугольнички на карте. Каждый сектор приносит определённый доход клану и его членам за каждый ход.
        На секторах можно строить различные улучшения, как <b> харвестер</b>, и прочие.
    </ul>



    <hr style="size: 6px; width: calc(100%-20px);">

    <h1 style="text-align: center; color: lightgray; letter-spacing: 0.2em;">News</h1>

    <hr style="size: 6px; width: calc(100%-20px);">

    <p>

    </p>

        <br>
        <center><img src="images/game-process.png" style="max-width: 80%;"></center>
        <br>
        <center><img src="images/sessions.png" style="max-width: 80%;"></center>
        <br>



</div>

<!-- Container />, Footer </ -->

<div id="footer">

</div>

</body>

</html>