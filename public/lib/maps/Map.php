<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 16.02.2019
 * Time: 18:09
 */

use Main\Data;
use User\User;

class Map
{
    /**
     * @var eSafeMySQL
     */
    static $db;

    protected $clansN;

    protected $name;

    protected $id;

    /**
     * @var User
     */
    protected $creator;

    static function setDB( eSafeMySQL $db){
        self::$db = $db;
    }

    public function find( $type , $value )
    {
        $db = self::$db;

        $type = eSafeMySQL::whiteList($type, array('id', 'name'));

        if (!$type OR empty($value) OR ($value == -1) ) return new Data([
            'errText' => 'Not valid entry in Map::find',
            'errCode' => 401,
        ]);

        $in  = ($type === 'id') ? '?i' : '?s';
        $sql = "SELECT * FROM maps WHERE ?n=".$in;

        $res = $db->getRow($sql, $type, $value);

        // No such map
        if (!$res) return new Data([
            'errText' => 'No such map found',
            'errCode' => 404,
        ]);

        $this->creator = new User('id', $res['creator']);
        $this->name    = $res['name'];
        $this->id      = $res['id'];

        return new Data;
    }


}