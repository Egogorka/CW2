
<!-- mod start -->

<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/lib/main/mysql.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/userRequests/userRequests.php';

$userReq = new UserRequests;

UserRequests::$db = $db;

////////////////////////////////////////////////////////////////////
// Подключаем скрипты, если ещё не подключили, с помощью JSEnable
////////////////////////////////////////////////////////////////////

    global $_JSEnable;
    $_JSEnable->enable("/lib/windows/win.js");

////////////////////////////////////////////////////////////////////
// HTML блок
////////////////////////////////////////////////////////////////////
    ?>

    <div class="window" id="clan_window" style="
    width: calc(100% - 10px);
    height: calc(100% - 10px);

    background-color: #454545;
    box-shadow: inset 0 0 30px #070707;
">
        <div style="height: 100%; width: 100%;">
            <h2> Info </h2>

            <hr style="size: 6px; width: calc(100%-20px);">

            <h2> Chat </h2>

            <hr style="size: 6px; width: calc(100%-20px);">

            <h2> List of users </h2>

            <hr style="size: 6px; width: calc(100%-20px);">

            <h2> Voting </h2>

            <hr style="size: 6px; width: calc(100%-20px);">

            <h2> Requests </h2>

            <?php $userReq->iShowList(100, 100); ?>

            <hr style="size: 6px; width: calc(100%-20px);">

            <button onclick="win_hide('clan_window')">Close</button>
        </div>
    </div>

    <?php
////////////////////////////////////////////////////////////////////
// Личный JS код
////////////////////////////////////////////////////////////////////
    ?>

    <script type="text/javascript">



    </script>

<?php  ?>

<!-- mod end -->