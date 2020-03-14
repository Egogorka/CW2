<?php


namespace eduslim\interfaces\domain\plans;


use eduslim\interfaces\domain\mapstate\HexInterface;
use eduslim\interfaces\domain\user\UserInterface;

interface AttackInterface extends PlanInterface
{

    public function getHexTo():HexInterface;
    public function setHexTo(HexInterface $hex):void;

    public function getHexFrom():HexInterface;
    public function setHexFrom(HexInterface $hex):void;

    public function getUsers():array;
    public function setUsers(array $users):void;

    static function getFromJson( string $raw ):AttackInterface;
}