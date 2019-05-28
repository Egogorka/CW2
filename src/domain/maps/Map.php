<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 25.03.2019
 * Time: 18:10
 */

namespace eduslim\domain\maps;


use eduslim\interfaces\domain\maps\MapInterface;
use eduslim\interfaces\domain\user\UserInterface;

class Map implements MapInterface
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $map;

    /** @var int */
    protected $creator; // id


    // Setters

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setCreator(int $userId)
    {
        $this->creator = $userId;
    }

    public function setMap(string $map)
    {
        $this->map = $map;
    }


    // Getters

    public function getId():?int
    {
        return $this->id;
    }

    public function getName():?string
    {
        return $this->name;
    }

    public function getCreator():?int
    {
        return $this->creator;
    }

    public function getMap():?string
    {
        return $this->map;

    }
}
