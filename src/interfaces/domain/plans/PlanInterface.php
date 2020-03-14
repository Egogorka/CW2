<?php


namespace eduslim\interfaces\domain\plans;


interface PlanInterface
{
    const TYPES = [
        "attack",
        "build",
    ];

    public function setBudget(int $cash):void;
    public function getBudget():int;

}