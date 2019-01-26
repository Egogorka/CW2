<?php
/**
 * Created by PhpStorm.
 * User: Helene
 * Date: 09.01.2019
 * Time: 0:18
 */

use Main\Data\Data;
require_once 'UserModel.php';

class User extends UserModel
{
    protected $id;
    protected $name;
    protected $clan;

    public function getId()    { return $this->id;  }
    public function getName()  { return $this->name;}
    public function getClanID(){ return $this->clan;}

    // Find and assign a user if it exists
    public function find($type = 'id', $value = -1)
    {
        global $db;

        $type = eSafeMySQL::whiteList($type, array('id', 'username'));

        //No type, waiting for creating user
        if (!$type) return new Data([
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

        $this->clan = $res['clan_id'];
        $this->name = $res['username'];
        $this->id   = $res['id'];

        return new Data;
    }

    // Testing, if this password is true for this user
    public function pass( $pass )
    {
        global $db;

        $res = $db->getRow("SELECT * FROM users WHERE id = ?i", $this->id);

        if(!password_verify($pass, $res['pass_hash']))
            return new Data([
                'errText' => 'Password incorrect',
                'errCode' => 401,
                'response' => $pass,
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

    //
    public function toArray(){
        return [
            'name' => $this->name,
            'id'   => $this->id,
            'clan' => $this->clan,
        ];
    }
}