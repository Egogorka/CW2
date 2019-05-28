<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 06.02.2019
 * Time: 23:05
 */

/**
 * opts, array of
 *   Name : of lobby
 *   Map id
 *   List of clans
 *
 */


$winId = "LobbyFace_window";

////////////////////////////////////////////////////////////////////
// Подключаем скрипты, если ещё не подключили, с помощью JSEnable
////////////////////////////////////////////////////////////////////

global $_JSEnable;
$_JSEnable->enable("/lib/windows/win.js");

////////////////////////////////////////////////////////////////////
// HTML блок
////////////////////////////////////////////////////////////////////
?>

<div class="window" id="<?= $winId ?>" style="
    width: 700px;
    height: 600px;

    background-color: #454545;
    box-shadow: inset 0 0 30px #070707;
    ">

    <h1> Name : <?= $opts->name ?></h1>

    <div>
        <button onclick="win_hide('<?= $winId ?>')">Close</button>
    </div>
</div>

<?php
////////////////////////////////////////////////////////////////////
// Личный JS код
////////////////////////////////////////////////////////////////////
?>

<script type="text/javascript">



</script>

<?php ?>

<!-- mod end -->