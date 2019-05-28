<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 09.02.2019
 * Time: 17:00
 */

$winId = "LobbyCreate_window";
?>

    <center>
        <div class="search">
            <form>
                <label>SEARCH :<input type="text" style="vertical-align: middle"></label>
                <div class="greenbut button" onclick=""></div>
            </form>
            <div class="vr"></div>
            <img style="vertical-align: middle; height: 1.3em;" src="images/gear.png">
            <div class="vr"></div>
            <a href="#" onclick="win_show('<?= $winId ?>')"  class="graybut button">CREATE</a>
            <div class="vr"></div>
            <a href="#" class="graybut button">JOIN VIA ID</a>
        </div>
    </center>