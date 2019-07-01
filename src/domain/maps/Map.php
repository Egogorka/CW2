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
    protected $mapR;

    /** @var int */
    protected $creatorId; // id

    /** @var UserInterface */
    protected $creator;

    // Setters

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setCreatorId(int $userId)
    {
        $this->creator = $userId;
    }

    public function setMapR(string $mapR)
    {
        $this->mapR = $mapR;
    }

    public function setCreator(UserInterface $user)
    {
        $this->creator = $user;
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

    public function getCreatorId():?int
    {
        return $this->creatorId;
    }

    public function getMapR():?string
    {
        return $this->mapR;
    }

    public function getCreator(): ?UserInterface
    {
        return $this->creator;
    }
}
