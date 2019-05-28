<?php


namespace eduslim\interfaces\domain\sessions;


use eduslim\interfaces\domain\action\ActionInterface;
use eduslim\interfaces\domain\maps\MapInterface;

interface SessionManagerInterface
{
    function findById( int $id ):?SessionInterface;

    function findByName( string $name ):?SessionInterface;

    function findByMap( MapInterface $map ):?array; // of SessionInterface

    function findByAction( ActionInterface $action ):?array; // of SessionInterface

    function save( SessionInterface $session );
}