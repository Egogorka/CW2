<?php


namespace eduslim\application\controller;

use eduslim\domain\clan\ClansManager;
use eduslim\domain\session\SessionManager;
use eduslim\domain\sockets\SocketPackage;
use eduslim\domain\user\User;
use eduslim\domain\user\UserManager;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;

class SocketController
{

    /**
     * @var SessionManager
     */
    protected $sessionManager;

    /**
     * @var ClansManager
     */
    protected $clansManager;

    /**
     * @var UserManager
     */
    protected $userManager;

    /////////////////////

    /** @var Worker */
    protected $worker;

    /** @var array */ //чтобы не сетать самим connection'ам данные
    protected $connectionsData;

    /**
     * SocketController constructor.
     * @param SessionManager $sessionManager
     * @param ClansManager $clansManager
     * @param UserManager $userManager
     */
    public function __construct( SessionManager $sessionManager, ClansManager $clansManager, UserManager $userManager )
    {
        $this->sessionManager = $sessionManager;
        $this->clansManager = $clansManager;
        $this->userManager = $userManager;

        $this->connectionsData = [];
    }

    public function setWorker( Worker $worker ){
        $this->worker = &$worker;
    }

    /**
     * @param TcpConnection $connection
     */
    public function onConnection( TcpConnection $connection) {
        $connection->send("success");
    }

    /**
     * @param TcpConnection $connection
     * @param \JsonSerializable|string $rawData
     */
    public function onMessage( TcpConnection $connection, $rawData) {
        //$data = json_decode($rawData);
        $package = new SocketPackage($rawData);
        switch ($package->getType()){
            case SocketPackage::TYPES["verify"]:
                //$_COOKIE["PHPSESSID"] = $package->getData()->cookie;
                if( !is_integer($package->getData()->userId))
                    echo "ERROR : Wrong format of userId";
                else {
                    $this->connectionsData[$connection->id] = $this->userManager->findById($package->getData()->userId);
                    $connection->send(json_encode("Hello, " . $this->connectionsData[$connection->id]->getUsername()));
                }
                break;
            case SocketPackage::TYPES["message"]:
                /** @var TcpConnection $connect */
                foreach ($this->worker->connections as $connect){
                    $connect->send( json_encode([
                        "type" => "message",
                        "sender" => $this->connectionsData[$connection->id]->getUsername(),
                        "data" => $package->getData()
                    ]));
                }
                break;

        }
    }

    /**
     * @param TcpConnection $connection
     */
    public function onClose( TcpConnection $connection) {

    }

}