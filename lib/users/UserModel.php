<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 18.01.2019
 * Time: 17:54
 */

use Main\Data\Data;

class UserModel
{
    static function tPassword($in)
    {
        // TODO pass rules
        if(!is_string($in)) return new Data([
            'errText' => "UserObj : password is not a string",
            'errCode' => 400,
        ]);

        $in = trim($in);

        if( strlen($in) < 7 ) {
            return new Data([
                'errText' => 'Your password must contain at least 7 symbols',
                'errCode' => 400,
            ]);
        }

        return new Data([
            'response' => $in,
        ]);
    }

    ////////////////////////////////////////////////////////

    static function tName($in)
    {
        // TODO name rules
        if(!is_string($in)) return new Data([
            'errText' => "UserObj : name is not a string",
            'errCode' => 400,
        ]);

        $in = trim($in);

        if( strlen($in) < 5 ) {
            return new Data([
                'errText' => 'Your login must contain at least 5 symbols',
                'errCode' => 400,
            ]);
        }

        if( strlen($in) >= 20 ) {
            return new Data([
                'errText' => 'Your login must contain less than 20 symbols',
                'errCode' => 400,
            ]);
        }

        $res = self::tUser($in);
        if (!$res->isOk()) return $res;

        return new Data([
            'response' => $in,
        ]);
    }

    ////////////////////////////////////////////////////////
    // Proving mail is okay

    static function tMail($in)
    {
        if(!is_string($in)) return new Data([
            'errText' => "UserObj : mail is not a string",
            'errCode' => 400,
        ]);

        $in = trim($in);

        // TODO mail rules
        return new Data([
            'response' => $in,
        ]);
    }

    ////////////////////////////////////////////////////////

    static function tUser($name) {
        $user = new User;
        $res = $user->find('username', $name);

        if ($res->isOk()) return new Data ([
            'errText' => 'There already exists a user with that name',
            'errCode' => 401,
            'response' => $user->toArray(),
        ]);

        unset($user);
        return new Data;
    }
}