<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 06.04.2019
 * Time: 18:19
 */
?>

<h2> Leader Interface </h2>

<ul>
    <li>
        <h3>Users</h3>
    <form action="/clan/<?=$clan->getId()?>/leader/addUser/" method="get">
        <label>User to add : <input type="text" name="username"></label>
        <input type="submit" value="Add!">
    </form>
    </li>

    <li>
        <h3>Session</h3>
        <form action="/clan/<?=$clan->getId()?>/leader/addSession/" method="get">
            <label>Name : <input type="text" name="name"></label><br>
            <label>Map name : <input type="text" name="mapName"></label><br>
            <label>Action name : <input type="text" name="mapName"></label><br>
            <input type="submit" value="Add!">
        </form>
    </li>
</ul>

<hr style="size: 6px; width: calc(100%-20px);">