<?php


namespace eduslim\domain\sockets;


use eduslim\interfaces\domain\user\UserInterface;

class SocketPackage
{

    const TYPE_VERIFY = "verify";
    const TYPE_MESSAGE = "message";

    const TYPE_PLAN_CREATE = "plan_create";
    const TYPE_PLAN_DELETE = "plan_delete";

    const TYPE_PLANING_END = "planning_end";

    const TYPE_MAP_UPDATE = "map_update";


    const TYPES = [
        self::TYPE_MESSAGE,
        self::TYPE_VERIFY,

        self::TYPE_PLAN_CREATE,
        self::TYPE_PLAN_DELETE,

        self::TYPE_PLANING_END,

        self::TYPE_MAP_UPDATE,
        ];

    /** @var string */
    protected $type;

    protected $data;

    /** @var UserInterface|null */
    protected $sender;

    /**
     * SocketPackage constructor.
     * @param string $type
     * @param $data
     * @param UserInterface|null $sender
     */
    public function __construct($type = self::TYPE_MESSAGE, $data = null, $sender = null)
    {
        $this->type = $type;
        $this->data = $data;
        $this->sender = $sender;
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

    public function setSender( UserInterface $user ){
        $this->sender = $user;
    }

    /**
     * @return UserInterface|null
     */
    public function getSender()
    {
        return $this->sender;
    }

    public function getJson(){
        return json_encode([
            "type" => $this->getType(),
            "senderName" => ($this->sender) ? $this->sender->getUsername() : null,
            "data" => $this->getData() ?? null
        ]);
    }

    public function setFromJson( $json ){
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

}