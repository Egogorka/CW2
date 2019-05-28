<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 09.02.2019
 * Time: 16:50
 */

namespace Lobby;

require_once "view/LobbyView.php";
require_once "Lobby.php";

use Lobby\View\LobbyView;

class LobbyManager extends LobbyView
{
    public function create($creator, $name, $opts, $map, $eventer)
    {
        $lobby = new Lobby();
        $lobby->init($creator, $name, $opts, $map, $eventer);


    }
}