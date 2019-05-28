<!-- mod start -->

<?php
////////////////////////////////////////////////////////////////////
// Подключаем скрипты, если ещё не подключили, с помощью JSEnable
////////////////////////////////////////////////////////////////////

global $_JSEnable;
$_JSEnable->enable("/lib/windows/win.js");

////////////////////////////////////////////////////////////////////
// HTML блок
////////////////////////////////////////////////////////////////////
?>

<div class="window" id="clancr_window" style="
    width: 500px;
    height: 500px;

    background-color: #454545;
    box-shadow: inset 0 0 30px #070707;
">
    <div>
        <form id="clanCreateForm" action="/lib/clans/clanlog/constr.php">
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
        <button onclick="win_hide('clancr_window')">Close</button>
    </div>
</div>

<?php
////////////////////////////////////////////////////////////////////
// Личный JS код
////////////////////////////////////////////////////////////////////
?>

<script type="text/javascript">

    var form = GetByID('clanCreateForm');
    form.onsubmit = function () {

        var message = {
            type : form.elements.type.value,
            name : form.elements.name.value,
        };

        AjaxRequest('POST','/lib/clanlog/constr.php',JSON.stringify(message),function (response) {
            complain(response);
            if (response === "Everything ok, clan created"){
                win_hide('clancr_window');
                alert(response);
                window.location.reload();
            }
            //if (response === 'Ok') window.location.reload();
        },function () {alert('Time out');}, 7000);

        return false;
    };

</script>

<!-- mod end -->


