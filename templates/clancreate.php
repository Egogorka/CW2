<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 31.03.2019
 * Time: 21:49
 */
?>

<?=$this->layout("layouts/main/qwerty", ['title' => 'Create your clan', 'error' => $error ?? null]) ?>

<div style="display: flex; justify-content: center;">

    <form id="clan_form" class="qwertyForm" action="/clans/clancreate" method="post">
        <label >Name of the clan<input type="text" name="name"></label>  <br>
        Choose the type of the clan
        <ol>
            <li><label ><input type="radio" name="type" value="dict">Dictatorship</label></li>
            <li><label ><input type="radio" name="type" value="parl">Parliament</label></li>
            <li><label ><input type="radio" name="type" value="demo">Democracy</label></li>
            <li><label ><input type="radio" name="type" value="corp">Corporation</label></li>
        </ol>
        <label>Clan icon<input type="file" name="file"></label><br>
        <label><input type="submit" value="Create"></label><br><br>
    </form>

</div>