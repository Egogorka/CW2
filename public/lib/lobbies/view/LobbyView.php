<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 03.02.2019
 * Time: 21:50
 */

namespace Lobby\View;

use Lobby\Lobby;

class LobbyView
{
    /**
     * @var Lobby
     */

    static function showCreation()
    {
        require "create.php";
    }

    static function showLobby( Lobby $lobby )
    {
        $opts = $lobby;
        require "face.php";
    }

    protected function showClans ( $lobby )
    {


    }

}