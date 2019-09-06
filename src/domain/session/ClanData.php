<?php


namespace eduslim\domain\session;


use eduslim\domain\BaseException;

class ClanData implements \JsonSerializable
{

    /** @var array */
    protected $plannedAttacks = [];

    /** @var int */
    protected $budget = null;

    static $COLORS = [
        'neutral'=> 0, //not set
        'red'    => 1,
        'yellow' => 2,
        'green'  => 3,
        'cyan'   => 4,
        'blue'   => 5,
        'purple' => 6,
    ];

    protected $color = 0;

    /**
     * @param $json
     * throws BaseException
     */
    public function __construct(string $json=null){

        $array = json_decode($json ?? json_encode([]));

//        if(json_last_error() !== JSON_ERROR_NONE){
//            throw new BaseException("JSON for ClanInfo is malformed");
//        }

        $props = get_object_vars($this);
        foreach ($props as $key => $prop){

//            if(!key_exists($key, $array)) throw new BaseException($key." property is not set in JSON for ClanInfo");
//            $this[$key] = $array[$key];
            if(key_exists($key, $array))
                $this->$key = $array[$key];
        }
        return true;
    }

    public function getProp(string $name){
        $props = get_object_vars($this);
        return $props[$name];
    }

    public function setProp(string $name, $value){
        $props = get_object_vars($this);
        if(key_exists($name, $props)){
            $this->$name = $value;
            return true;
        }
        return false;
    }

    public function toJSON():string
    {
        return json_encode($this);
    }

    public function jsonSerialize(){
        return [
            'budget' => $this->getProp("budget"),
            'color'  => $this->getProp("color"),
            'plannedAttacks' => $this->getProp("plannedAttacks"),
        ];
    }

}