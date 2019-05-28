<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 03.02.2019
 * Time: 23:01
 */

namespace Sessions;

class SessionView
{

    static function sessionList($sessions)
    {
        foreach ($sessions as $row){
            echo $row['name'].' : Creator -&raquo '.$row['creator'].'<br>';
        }
    }

    static function searchBar()
    {
        include "searchbar.php";
    }
}