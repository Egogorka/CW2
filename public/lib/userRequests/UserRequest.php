<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 16.02.2019
 * Time: 16:56
 */

namespace UserRequest;

use Main\Data;
use Clan\Clan;
use User\User;

class UserRequest
{
    /**
     * @var \eSafeMySQL;
     */
    static $db;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Clan
     */
    protected $clan;

    protected $status;

    ///////////

    /**
     * @param $db \eSafeMySQL
     */
    static function setDB($db)
    {
        self::$db = $db;
    }

    /*public function __construct($user, $clan , $value)
    {

    }*/

    // Ищем по пользователю и клану реквест
    public function find( User $user, Clan $clan )
    {
        $db = self::$db;

        $sql = "SELECT * FROM user_requests WHERE user_id=?i AND clan_id=?i";
        $res = $db->query($sql, $user->getId(), $clan->getId());

        if (!$res ){
            return new Data([
                'errText' => 'Database error : no record of userRequest',
                'errCode' => 500,
            ]);
        }

        $this->clan   = $clan;
        $this->user   = $user;
        $this->status = $res['status'];

        return new Data();
    }

    //
    public function create( User $user, Clan $clan)
    {
        $db = self::$db;

        // Например сейчас, было бы удобно лишь найти
        $tmp = new UserRequest();

        if ( $tmp->find($user, $clan)->isOk() ){
            return new Data([
                'errText' => 'Database error: such record already exists',
                'errCode' => 500,
            ]);
        }
        unset($tmp); // im paranoid

        $sql  = "INSERT INTO user_requests (user_id, clan_id, status) VALUES (?i, ?i, 0)";
        $res  = $db->query($sql, $user->getId(), $clan->getId());

        if (!$res) { //Something wrong with db
            return new Data([
                'errText'  => 'Database error',
                'errCode'  => 501,
                'response' => $db->getStats(),
            ]);
        }

        return new Data();
    }

}