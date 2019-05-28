<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 23.03.2019
 * Time: 17:06
 */
?>

<?=$this->layout("layouts/main/qwerty", ['title' => 'Authentication', 'error' => $error ?? null]) ?>

<div style="display: flex; justify-content: center;">

    <form id="reg_form" style="background-color: #120e18; padding: 40px; box-shadow: inset 0 0 20px #3c3868;" action="/auth/signup/" method="post">

        <h2 align="center">Sign up</h2>

        <label><input type="text" name="username"> Login</label><br><br>

        <label><input type="password" name="password"> Password</label><br><br>

        <label><input type="email" name="email"> Email</label><br><br>

        <input type="submit" style="color:black;" value="Send"> <a href="/"> Return back </a>

    </form>

</div>

<!--<script src="/javascript/auth/signup.js"></script>-->
