<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 09.02.2019
 * Time: 16:39
 */

namespace Map;


class MapView
{
    static function mapList()
    {
        global $db;

        $res = $db->getAll('SELECT * FROM maps');

        foreach ($res as &$row) {
            $row['creator'] = $db->getRow('SELECT * FROM users WHERE id = ?i', $row['creator']);
        }
        unset($row);

        foreach ($res as $row) {

            echo $row['name'].' : Creator -&raquo '.$row['creator']['username'].'<br>';

            echo "<img src='/images/maps/".$row['name'].".png'><br>";
        }
        unset($row);
    }

    static function searchBar()
    {
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
                <a href="old_mapeditor/mapeditor/index.html" class="graybut button">CREATE</a>
            </div>
        </center>

        <?php
    }
}