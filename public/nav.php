<?php
global $navInput;

if ($navInput === "main"){
    ?>
    <a class="nav a1 a_cur" href="#">
        MAIN
    </a>
    <a class="nav a2" href="clans.php">
        CLAN
    </a>
    <a class="nav a3" href="sessions.php">
        SESSIONS
    </a>
    <a class="nav a4" href="maps.php">
        MAPS
    </a>
    <?php
}
elseif ($navInput === "clans"){
    ?>
    <a class="nav a1" href="index.php">
        MAIN
    </a>
    <a class="nav a2 a_cur" href="#">
        CLAN
    </a>
    <a class="nav a3" href="sessions.php">
        SESSIONS
    </a>
    <a class="nav a4" href="maps.php">
        MAPS
    </a>
    <?php
}
elseif ($navInput === "maps"){
    ?>
    <a class="nav a1" href="index.php">
        MAIN
    </a>
    <a class="nav a2" href="clans.php">
        CLAN
    </a>
    <a class="nav a3" href="sessions.php">
        SESSIONS
    </a>
    <a class="nav a4 a_cur" href="#">
        MAPS
    </a>
    <?php
}
elseif ($navInput === "sessions"){
    ?>
    <a class="nav a1" href="index.php">
        MAIN
    </a>
    <a class="nav a2" href="clans.php">
        CLAN
    </a>
    <a class="nav a3 a_cur" href="sessions.php">
        SESSIONS
    </a>
    <a class="nav a4" href="maps.php">
        MAPS
    </a>
    <?php
}