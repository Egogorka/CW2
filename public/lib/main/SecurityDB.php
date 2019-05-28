<?php

require "Data.php";
require "mysql.php";

class eSafeMySQL extends SafeMySQL
{
    public function doesExist($table, $in){
        // in - assoc. array with key - column, and value - value;
        // example : SELECT * FROM $table WHERE key=value AND key=value ...
        reset($in);

        $s = " ?n=?s ";
        $par = [];
        foreach ($in as $key => $value) {
            $par[] = $this->parse($s, $key, $value);
        }
        $sql = implode(" AND ", $par);

        $res = $this->query("SELECT * FROM ?n WHERE ?p", $table, $sql);

        return ($res) ? true : false;
    }
}
