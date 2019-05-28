<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 12.01.2019
 * Time: 12:51
 */

namespace Map;

class Cell
{

    const NEUTRAL = 0;
    const NONE = 0;

    const STRUCTURES = [
        'space'     => 0,
        'empty'     => 1,
        'base'      => 2,
        'harvester' => 3,
    ];

    protected $clanNum; //
    protected $structureNum; // number of structure

    // Why not a pointer on Structure? I dunno.

    function __construct($clan, $structure)
    {
        if( empty($clan) ) {
            $this->clanNum = self::NEUTRAL;
        } else {
            $this->clanNum = (int)$clan;
        }

        if( empty($structure) ){
            $this->structureNum = self::NONE;
        } else {
            $this->structureNum = (int)$structure;
        }
    }

    public function getClan()
    {
        return $this->clanNum;
    }

    public function getBuild()
    {
        return $this->structureNum;
    }

}