<?php

namespace eduslim\domain\user;

use eduslim\interfaces\domain\clan\ClanInterface;
use eduslim\interfaces\domain\user\UserInterface;

class User implements UserInterface
{
    protected $id;

    protected $username;

    protected $pass_hash;

    protected $email;

    protected $clan;

    protected $clanId;




    // Setters

    public function setId( int $id )
    {
        $this->id = $id;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    public function setPassHash(string $pass_hash)
    {
        $this->pass_hash = $pass_hash;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function setClanId(int $id)
    {
        $this->clanId = $id;
    }

    public function setClan(ClanInterface $clan)
    {
        $this->clan = $clan;
    }


    // Getters

    public function getId():? int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPassHash(): ?string
    {
        return $this->pass_hash;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getClanId(): ?int
    {
        return $this->clanId;
    }

    public function getClan(): ?ClanInterface
    {
        return $this->clan;
    }

}