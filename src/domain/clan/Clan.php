<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 25.03.2019
 * Time: 20:23
 */

namespace eduslim\domain\clan;


use eduslim\interfaces\domain\clan\ClanInterface;
use eduslim\interfaces\domain\user\UserInterface;

class Clan implements ClanInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $leaderId;

    /**
     * @var UserInterface
     */
    protected $leader;

    // Setters
    public function setId(int $id)
    {
        $this->id = $id;

    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setLeaderId(int $leader)
    {
        $this->leaderId = $leader;
    }

    public function setLeader(UserInterface $leader)
    {
        $this->leader = $leader;
    }


    //Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getLeaderId(): ?int
    {
        return $this->leaderId;
    }

    public function getLeader(): ?UserInterface
    {
        return $this->leader;
    }
}