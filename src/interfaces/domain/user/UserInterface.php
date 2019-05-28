<?php
/**
 * User: ivan
 * Date: 24.02.19
 * Time: 23:29
 */

namespace eduslim\interfaces\domain\user;

use eduslim\interfaces\domain\clan\ClanInterface;

interface UserInterface
{

    // Setters

    public function setId( int $id);

    public function setUsername( string $username);

    public function setPassHash( string $password_hash);

    public function setEmail( string $email);

    public function setClan( ClanInterface $clan );

    public function setClanId( int $id );


    // Getters

    public function getId():? int;

    public function getUsername():? string ;

    public function getPassHash():? string ;

    public function getEmail():? string ;

    public function getClanId():? int;

    public function getClan():? ClanInterface;


}