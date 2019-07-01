<?php


namespace eduslim\domain\session;


use eduslim\domain\BaseException;

class ClanData
{




    /** @var int */
    protected $budget;

    /** @throws BaseException */
    public function __construct(string $json){
        $array = json_decode($json);

        if(json_last_error() !== JSON_ERROR_NONE){
            throw new BaseException("JSON for ClanInfo is malformed");
        }

        $props = get_object_vars($this);
        foreach ($props as $key => $prop){

            if(!key_exists($key, $array)) throw new BaseException($key." property is not set in JSON for ClanInfo");
            $this[$key] = $array[$key];

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
            $this[$name] = $value;
            return true;
        }
        return false;
    }

    public function toJSON():string
    {
        return json_encode($this);
    }

}