<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 13.01.2019
 * Time: 18:42
 */

namespace Clan;

use Main\Data;
use eSafeMySQL;
use User\User;

class Clan
{
    protected $id;
    public $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    protected $leader;
    protected $type;

    static $db;

    /**
     * @param eSafeMySQL $db
     */
    static function setDb($db)
    {
        Clan::$db = $db;
    }



    public function assign($res)
    {
        $this->type   = $res['type'] ?? null;

        $this->leader = $res['leader_id'] ?? null;
        $this->leader = User::find('id', $this->leader, true)->response;

        $this->name   = $res['name'] ?? null;
    }

    static function find( $type = "id", $value = -1, $return_clan = false){
        $db = Clan::$db;

        $type = eSafeMySQL::whiteList($type, array('id', 'name', 'leader_id'));

        //No type, waiting for creating clan
        if (!$type OR empty($value) OR ($value == -1)) return new Data([
            'errText' => 'Not valid entry in Clan::find, no type',
            'errCode' => 501,
        ]);

        $in  = ($type === 'id' || $type === 'leader_id') ? '?i' : '?s';
        $sql = "SELECT * FROM clans WHERE ?n=".$in;

        $res = $db->getRow($sql, $type, $value);

        // No such clan
        if (!$res) return false;

        $out = new Data;

        if ($return_clan === true) {
            $clan = new Clan;
            $clan->assign($res);

            $out->response = $clan;
        }

        return $out;

    }

    /* User - object (already tested :)
     * Name - string, containing the name of the clan
     * Type - wtf
     */
    public function create( User $creator, $name, $type){
        global $db;

        // Try finding such clan;
        $name = trim($name);

        $out = new Data;

        $out->changeBy($this->testName($name));
        $out->changeBy($this->testType($type));


        $sql = 'INSERT INTO clans (name, leaderId) VALUES (?s, ?i)';
        $res = $db->query($sql, $name, $creator->getId());
        if ( !$res ){
            return new Data([
                'errText'  => 'Database error',
                'errCode'  => 501,
                'response' => $db->getStats(),
            ]);
        }

        $this->name   = $name;
        $this->leader = $creator->getId();
        $this->type   = $type;

        // TODO Registration conformation
        return new Data([
            'response' => 'Creation success',
        ]);

    }

    static function testExist($type, $value){
        // Try
        $test = new Clan;
        $res = $test->find($type, $value);

        if ($res) return new Data([
            'errText' => 'Such clan already exists',
            'errCode' => 400,
        ]);

        return new Data;
    }

    protected function testType($type){
        if (!is_int($type))
            return new Data([
                'errText' => 'Type is not an integer',
                'errCode' => 400,
            ]);
        return new Data();
    }

    protected function testName($name){

        // TODO Make a clan_name tester
        if( strlen($name) < 3 ) {
            return new Data([
                'errText' => 'Clan name must contain at least 3 symbols',
                'errCode' => 400,
            ]);
        }

        if( strlen($name) >= 15 ) {
            return new Data([
                'errText' => 'Clan name must contain less than 15 symbols',
                'errCode' => 400,
            ]);
        }

        return new Data;
    }

}