<?php


namespace eduslim\domain\session;


use eduslim\domain\BaseException;
use eduslim\domain\session\plans\attack\Attack;
use eduslim\domain\session\plans\PlanTemp;
use eduslim\interfaces\domain\plans\PlanInterface;

class ClanData
{

    const PLANNING_DEFAULT = 0;
    const PLANNING_END = 1;

    static $COLORS = [
        'neutral'=> 0, //not set
        'purple' => 1,
        'red'    => 2,
        'yellow' => 3,
        'green'  => 4,
        'cyan'   => 5,
        'blue'   => 6,
    ];

    protected $color = 0;
    protected $budget = 0;

    /** @var PlanTemp[] */
    protected $plans = [];

    /** @var int */
    protected $plansStatus = 0;

    /**
     * ClanData constructor.
     * @param int $color
     * @param int $budget
     * @param string $rawPlans
     * @param int $plansStatus
     */
    public function __construct(?int $color=0, ?int $budget=0, ?string $rawPlans='[]', ?int $plansStatus=self::PLANNING_DEFAULT)
    {
        if( is_null($color) ) $color = self::$COLORS["neutral"];
        if( is_null($budget)) $budget = 0;
        if( is_null($rawPlans)) $rawPlans = '[]';
        if( is_null($plansStatus)) $plansStatus = self::PLANNING_DEFAULT;

        $temp = json_decode($rawPlans);

        $plans = [];
        foreach ($temp as $a){
            $plans[] = PlanTemp::getFromJson(json_encode($a));
        }

        $this->color = $color;
        $this->budget = $budget;
        $this->plans = $plans;
        $this->plansStatus = $plansStatus;
    }


    /**
     * @return int
     */
    public function getColor(): int
    {
        return $this->color;
    }

    /**
     * @param int $color
     */
    public function setColor(int $color): void
    {
        $this->color = $color;
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
     * @return PlanTemp[]
     */
    public function getPlans(): ?array
    {
        return $this->plans;
    }

    /**
     * @param PlanTemp[] $plans
     */
    public function setPlans(array $plans): void
    {
        $this->plans = $plans;
    }

    public function addPlan(PlanTemp $plan): void
    {
        $this->plans[] = $plan;
    }

    /**
     * @return int
     */
    public function getPlansStatus(): int
    {
        return $this->plansStatus;
    }

    /**
     * @param int $planStatus
     */
    public function setPlansStatus(int $planStatus): void
    {
        $this->plansStatus = $planStatus;
    }
}

// Extendable properties
//    public function getProp(string $name){
//        $props = get_object_vars($this);
//        return $props[$name];
//    }
//
//    public function setProp(string $name, $value){
//        $props = get_object_vars($this);
//        if(key_exists($name, $props)){
//            $this->$name = $value;
//            return true;
//        }
//        return false;
//    }