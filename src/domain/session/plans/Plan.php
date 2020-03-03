<?php


namespace eduslim\domain\session\plans;


class Plan
{
    static $TYPES = [
        "attack",
        "build",
    ];

    /** @var int */
    protected $type;

    /** @var object */
    protected $object;

    public function __construct($type, $object)
    {
        $this->type = $type;
        $this->object = $object;
    }


}