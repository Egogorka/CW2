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

<div class="window" id="clanJBI_win" style="
    width: 500px;
    height: 300px;

    background-color: #454545;
    box-shadow: inset 0 0 30px #070707;
">
    <div>
        <form id="join_form" action="/lib/userRequests/joinAct.php" method="post">
            <p align="center">Type in the name of the clan you want to join</p>
            <label>Name: <input type="text" name="name"></label><br>
            <input type="submit" style="color:black;" value="Send">
        </form>
        <br>
        <button onclick="win_hide('clanJBI_win');">Close</button>
    </div>
</div>

<?php
////////////////////////////////////////////////////////////////////
// Личный JS код
////////////////////////////////////////////////////////////////////
?>

<script>

    GetByID('clanJBI').onclick = function () { win_show('clanJBI_win');};

    GetByID('join_form').onsubmit = function () {

        var message = {
            clanName : this.elements.name.value,
        };

        AjaxRequest('POST','/lib/userRequests/joinAct.php',JSON.stringify(message),function (response) {
            alert(response);
        },function () {
            alert('Time out');
        }, 7000);

        return false;
    }

</script>