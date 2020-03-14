<?php


namespace eduslim\domain\session\plans;


use eduslim\interfaces\domain\plans\PlanInterface;

class PlanTemp implements PlanInterface
{
    /** @var int */
    protected $budget;

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
}