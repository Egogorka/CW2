<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 02.02.2019
 * Time: 19:10
 */

// Lobby is the first stage of Session

namespace Lobby;

use Clan\Clan;

class Lobby
{
    public $name;

    /**
     * @var Clan
     */
    public $creator; // creator clan

    /**
     * @var array
     */
    protected $clans = [];

    protected $opts = [];

    /**
     * @var \Map\Map
     */
    public $map;

    public $eventer;

    public function init( Clan $creator, $name, $opts, $map, $eventer){
        $this->creator  = $creator;
        $this->opts     = $opts;
        $this->map      = $map;
        $this->eventer  = $eventer;
        $this->name     = $name;
    }

    public function addClan( Clan $clan ){

        $N = $this->map->clansN;

        for($i = 0; $i < $N ; $i++){

            if( !isset($this->clans[$i]) ) {
                $this->clans[$i] = $clan;
                return true;
            }

        }

        return false;

    }

    public function removeClan( Clan $clan  ){

        $arr = &$this->clans;

        unset( $arr[$this->findKey($clan)] );
        reset($arr);

    }

    public function swapClans( Clan $c1, Clan $c2) {
        $k1 = $this->findKey($c1);
        $k2 = $this->findKey($c2);

        $tmp = $this->clans[$k1];
        $this->clans[$k1] = $this->clans[$k2];
        $this->clans[$k2] = $tmp;
    }

    protected function findKey( Clan $c ){

        foreach ($this->clans as &$v  ){
            if ($c->getId() == $c->getId() ) {
                return key($this->clans);
            }
        }
        return -1;

    }
}