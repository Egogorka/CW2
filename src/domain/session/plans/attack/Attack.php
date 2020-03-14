<?php


namespace eduslim\domain\session\plans\attack;


use eduslim\domain\mapstate\Cell;
use eduslim\domain\mapstate\Hex;
use eduslim\domain\mapstate\OffsetCoordinate;
use eduslim\domain\session\plans\Plan;
use eduslim\domain\session\plans\PlanTemp;
use eduslim\domain\user\User;
use eduslim\interfaces\domain\mapstate\HexInterface;
use eduslim\interfaces\domain\plans\AttackInterface;
use eduslim\interfaces\domain\user\UserInterface;

class Attack extends PlanTemp implements AttackInterface
{
    /** @var HexInterface */
    protected $hexTo;

    /** @var HexInterface */
    protected $hexFrom;

    /** @var UserInterface[] */
    protected $users;

    /**
     * Attack constructor.
     * @param int $budget
     * @param HexInterface $hexTo
     * @param HexInterface $hexFrom
     * @param UserInterface[] $users
     */
    public function __construct(int $budget, HexInterface $hexTo, HexInterface $hexFrom, array $users)
    {
        parent::__construct($budget);
        $this->hexTo = $hexTo;
        $this->hexFrom = $hexFrom;
        $this->users = $users;
    }

    /**
     * @return HexInterface
     */
    public function getHexTo(): HexInterface
    {
        return $this->hexTo;
    }

    /**
     * @param HexInterface $hexTo
     */
    public function setHexTo(HexInterface $hexTo): void
    {
        $this->hexTo = $hexTo;
    }

    /**
     * @return HexInterface
     */
    public function getHexFrom(): HexInterface
    {
        return $this->hexFrom;
    }

    /**
     * @param HexInterface $hexFrom
     */
    public function setHexFrom(HexInterface $hexFrom): void
    {
        $this->hexFrom = $hexFrom;
    }

    /**
     * @return UserInterface[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    /**
     * @param UserInterface[] $users
     */
    public function setUsers(array $users): void
    {
        $this->users = $users;
    }

    static function getFromJson(string $raw): AttackInterface
    {
        $arr = json_encode($raw);
        $hexTo = new Hex(
            new Cell($arr["hexTo"]["cell"]["color"], $arr["hexTo"]["cell"]["structure"]),
            new OffsetCoordinate($arr["hexTo"]["coordinate"]["x"], $arr["hexTo"]["coordinate"]["y"])
        );
        $hexFrom = new Hex(
            new Cell($arr["hexFrom"]["cell"]["color"], $arr["hexFrom"]["cell"]["structure"]),
            new OffsetCoordinate($arr["hexFrom"]["coordinate"]["x"], $arr["hexFrom"]["coordinate"]["y"])
        );
        /** @var static $user */
        $users = [];
        foreach ($arr["users"] as $username){
            $user = new User();
            $user->setUsername($username);
            $users[] = $user;
        }
        return new Attack($arr["budget"], $hexTo, $hexFrom, $users);
    }

}