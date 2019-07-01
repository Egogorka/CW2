<?php


namespace eduslim\interfaces\domain\sessions;


use eduslim\domain\session\ClanData;
use eduslim\interfaces\domain\action\ActionInterface;
use eduslim\interfaces\domain\clan\ClanInterface;
use eduslim\interfaces\domain\maps\MapInterface;

interface SessionManagerInterface
{
    function findById( int $id ):?SessionInterface;
    function findByName( string $name ):?SessionInterface;
    function findByMap( MapInterface $map ):?array; // of SessionInterface
    function findByAction( ActionInterface $action ):?array; // of SessionInterface

    function addClan( SessionInterface $session, ClanInterface $clan );
    function removeClan( SessionInterface $session, ClanInterface $clan);

    function getClanData( SessionInterface $session, ClanInterface $clan ):?ClanData;
    function setClanData( SessionInterface $session, ClanInterface $clan, ClanData $data);

    function save( SessionInterface $session );
}