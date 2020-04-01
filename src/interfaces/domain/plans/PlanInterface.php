<?php


namespace eduslim\interfaces\domain\plans;


interface PlanInterface extends \JsonSerializable
{
    const TYPE_ATTACK = "attack";
    const TYPE_BUILD = "build";

    const TYPES = [
        "attack",
        "build",
    ];

    public function setBudget(int $cash):void;
    public function getBudget():int;

    public function getType():int;

    static function getFromJson(string $raw):PlanInterface;
}