<?php


namespace eduslim\domain\session\plans;


use eduslim\domain\session\plans\attack\Attack;
use eduslim\interfaces\domain\plans\PlanInterface;

abstract class PlanTemp implements PlanInterface
{


    /** @var int */
    protected $budget;

    /** @var int */
    protected $type;

    /**
     * PlanTemp constructor.
     * @param int $budget
     */
    public function __construct(int $budget)
    {
        $this->budget = $budget;
    }

    /**
     * @return int
     */
    public function getBudget(): int
    {
        return $this->budget;
    }

    /**
     * @param int $budget
     */
    public function setBudget(int $budget): void
    {
        $this->budget = $budget;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    static function getFromJson(string $raw):PlanInterface
    {
        $arr = json_decode($raw);
        switch ($arr->type){
            default:
            case self::TYPE_ATTACK:
                return Attack::getFromJson($raw);
                break;
//            case self::TYPE_BUILD:
//                break;
        }
    }

    abstract public function jsonSerialize();
}