<?php
/**
 * Created by PhpStorm.
 * User: Helene
 * Date: 09.01.2019
 * Time: 0:18
 */

namespace User;

use eSafeMySQL;

use Main\Data;
require_once 'UserModel.php';

class User extends UserModel
{
    protected $id;
    protected $name;
    protected $clan;

    static $db;

    /**
     * @param eSafeMySQL $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }

    public function getId()    { return $this->id;  }
    public function getName()  { return $this->name;}
    public function getClanID(){ return $this->clan;}

    public function __construct($type = '', $value = -1)
    {
        if($value === -1) return;

        $tmp = User::find($type, $value, true)->response;

        $this->clan = $tmp->getClanID();
        $this->name = $tmp->getName();
        $this->id   = $tmp->getId();
    }

    public function assign($res)
    {
        $this->id   = $res['id'] ?? null;
        $this->clan = $res['clan_id'] ?? null;
        $this->name = $res['username'] ?? null;
    }

    // Find and assign a user if it exists
    static function find($type = 'id', $value = -1, $return_user = false)
    {
        $db = User::$db;

        $type = eSafeMySQL::whiteList($type, array('id', 'username'));

        //No type, waiting for creating user
        if (!$type OR empty($value) OR ($value == -1) ) return new Data([
            'errText' => 'Not valid entry in User::find',
            'errCode' => 401,
        ]);

        $in  = ($type === 'id') ? '?i' : '?s';
        $sql = "SELECT * FROM users WHERE ?n=".$in;

        $res = $db->getRow($sql, $type, $value);

        // No such user
        if (!$res) return new Data([
            'errText' => 'No such user found',
            'errCode' => 404,
        ]);

        $out = new Data;

        if ($return_user === true) {
            $user = new User;
            $user->assign($res);

            $out->response = $user;
        }

        return $out;
    }

    // Testing, if this password is true for this user
    public function pass( $pass )
    {
        $db = User::$db;

        $res = $db->getRow("SELECT * FROM users WHERE id = ?i", $this->id);

        if(!password_verify($pass, $res['pass_hash']))
            return new Data([
                'errText' => 'Password incorrect',
                'errCode' => 401,
                'response' => password_hash($pass, PASSWORD_DEFAULT).' '.$res['pass_hash'],
            ]);

        return new Data;
    }

    // $inArr - associative array
    public function create($name = null , $pass = null, $mail = null){
        global $db;

        $res = self::tPassword($pass);
        if(!$res->isOk()) return $res;
        $pass = $res->response;

        $res = self::tName($name);
        if(!$res->isOk()) return $res;
        $name = $res->response;

        $res = self::tMail($mail);
        if(!$res->isOk()) return $res;
        $mail = $res->response;

        $sql = "INSERT INTO users (username,pass_hash,email) VALUES (?s,?s,?s)";
        $res = $db->query($sql, $name, password_hash($pass, PASSWORD_DEFAULT), $mail);

        if ( !$res ){
            return new Data([
                'errText'  => 'Database error',
                'errCode'  => 501,
                'response' => $db->getStats(),
            ]);
        }

        $this->clan = null;
        $this->name = $name;
        $this->id   = $db->insertId();

        // TODO Registration conformation
        return new Data([
            'response' => 'Registration success',
        ]);

    }
}