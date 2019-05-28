<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 06.02.2019
 * Time: 21:17
 */

$winId = "LobbyCreate_window";

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
    <div style=" width: 100%; height: 100%;">
        <h2 align="center">Enter your options for a session</h2>

        <form id="log_form" action="/lib/users/userlog/login.php" method="post">
            <label>Name    <input type="text" name="login"> </label><br>
            <label>Map     <input type="text" name="map"> </label><br>
            <label>Eventer <input type="text" name="eventer"> </label><br>
            <input type="submit" style="color:black;" value="Send">
        </form>
        <div>
            <button onclick="win_hide('<?= $winId ?>')">Close</button>
        </div>
    </div>
</div>

<?php
////////////////////////////////////////////////////////////////////
// Личный JS код
////////////////////////////////////////////////////////////////////
?>

<script type="text/javascript">

    {
        let form = GetByID('<?= $winId ?>');
        form.onsubmit = function () {

            var message = {
                name: form.elements.name.value,
                map: form.elements.map.value, // ID
                eventer: form.elements.eventer.value ,   // ID
                type : "create",
            };

            AjaxRequest('POST', '/lib/lobbies/lobbytmp', JSON.stringify(message), function (response) {
                alert(response);
                let input = JSON.parse(response);
                if (input.errCode === 200) window.location.reload();
            }, function () {
                alert('Time out');
            }, 7000);

            return false;
        };
    }

</script>

<?php ?>

<!-- mod end -->