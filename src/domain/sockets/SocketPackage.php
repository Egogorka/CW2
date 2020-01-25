<?php


namespace eduslim\domain\sockets;


class SocketPackage
{

    const TYPE_VERIFY = "verify";
    const TYPE_MESSAGE = "message";
    const TYPE_PLAN = "plan";

    const TYPES = [
        self::TYPE_MESSAGE,
        self::TYPE_VERIFY,
        self::TYPE_PLAN,
    ];

    /** @var string */
    protected $type;

    protected $data;

    public function __construct($json)
    {
        $raw = json_decode($json);
        if( !key_exists("type",$raw) ) {
            echo "ERROR : There is no type of socket-package\n";
            dump($raw);
        }

        if (!in_array($raw->type, self::TYPES)) {
            echo "ERROR : The type of the socket-package is not listed in types\n";
            dump($raw);
            dump(self::TYPES);
        }

        $this->type = $raw->type;
        $this->data = $raw->data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

}