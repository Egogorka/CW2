<?php

////////////////////////////////////////////////////////////////////
// Подключаем php-модули
////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
// Подключаем скрипты, если ещё не подключили, с помощью JSEnable
////////////////////////////////////////////////////////////////////

global $_JSEnable;
$_JSEnable->enable("/lib/windows/win.js");

////////////////////////////////////////////////////////////////////
// HTML блок
////////////////////////////////////////////////////////////////////
?>

<div id="logImg">
    <img src="/images/user.png" style="width: 80px; margin: 10px;">
</div>

<div class="window" id="user_window" style="
    width: 500px;
    height: 500px;

    background-color: #454545;
    box-shadow: inset 0 0 30px #070707;
">
    <div>
        <button onclick="win_hide('user_window');">Close</button>
        <button onclick="AjaxRequest('GET','/lib/users/userlog/unlog.php',function() {}); window.location.reload();">Unlog</button>
    </div>
</div>

<?php
////////////////////////////////////////////////////////////////////
// Личный JS код
////////////////////////////////////////////////////////////////////
?>

<script>

    let logImg = GetByID("logImg");
    logImg.style.top = window.innerHeight/2 - 3*logImg.offsetHeight/2 + "px";
    logImg.style.left = '0px';

    logImg.onclick = function () { win_show('user_window');};

</script>