<?php


namespace eduslim\application\controller;

use eduslim\domain\clan\ClansManager;
use eduslim\domain\session\SessionManager;
use eduslim\domain\sockets\SocketPackage;
use eduslim\domain\user\User;
use eduslim\domain\user\UserManager;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;

class SessionSocketController
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


    // Это должен быть двумерный массив connection'ов, где первый ключ - id сессии, второй - id клана, а значение - дата, закреплённая за коннектом
    /** @var TcpConnection[][] */
    protected $connections;

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
        $this->connections = [];
    }

    public function setWorker( Worker $worker ){
        $this->worker = &$worker;
    }

    /**
     * @param TcpConnection $connection
     */
    public function onConnection( TcpConnection $connection) {

    }

    /**
     * @param TcpConnection $connection
     * @param \JsonSerializable|string $rawData
     */
    public function onMessage( TcpConnection $connection, $rawData) {
        //$data = json_decode($rawData);
        $package = new SocketPackage();

        $package->setFromJson($rawData);

        if( key_exists($connection->id, $this->connectionsData))
            $package->setSender($this->connectionsData[$connection->id]);
        else
            if( $package->getSender() )
        dump($package);
        switch ($package->getType()){
            case SocketPackage::TYPE_VERIFY:
                $this->verify($connection, $package); break;
            case SocketPackage::TYPE_MESSAGE:
                $this->message($connection, $package); break;
            case SocketPackage::TYPE_PLAN_CREATE:
                $this->planCreate($connection, $package); break;
            case SocketPackage::TYPE_PLAN_DELETE:
                $this->planDelete($connection, $package); break;

        }
    }

    /**
     * @param TcpConnection $connection
     */
    public function onClose( TcpConnection $connection) {

    }

    private function verify( TcpConnection $connection, SocketPackage $package ) {
        //$_COOKIE["PHPSESSID"] = $package->getData()->cookie;

        if( !intval($package->getData()->userId) ) { //проверяем, можно ли привести к числу
            echo "ERROR : Wrong format of userId";
            return;
        }

        if( !intval($package->getData()->sessionId) ) {
            echo "ERROR : Wrong format of sessionId";
            return;
        }

        if( !intval($package->getData()->clanId) ){
            echo "ERROR : Wrong format of clanId";
            return;
        }

        $this->connectionsData[$connection->id] = $this->userManager->findById($package->getData()->userId);

        if(!key_exists($package->getData()->sessionId, $this->connections)) {
            $this->connections[$package->getData()->sessionId] = [];
        }
        $this->connections[$package->getData()->sessionId][$package->getData()->clanId] = $connection;

        $packageOut = new SocketPackage(SocketPackage::TYPE_MESSAGE, "Hello, " . $this->connectionsData[$connection->id]->getUsername() );

        $connection->send($packageOut->getJson());

    }

    private function message( TcpConnection $connection, SocketPackage $package ) {


        /** @var TcpConnection $connect */
        foreach ($this->worker->connections as $connect){
            $connect->send( json_encode([
                "type" => SocketPackage::TYPE_MESSAGE,
                "sender" => $this->connectionsData[$connection->id]->getUsername(),
                "data" => $package->getData()
            ]));
        }
    }

    private function planCreate( TcpConnection $connection, SocketPackage $package ) {
        // Понимаем, что это план (??)

        // Тут должна быть проверка плана на валидность

        // Суём план в базу данных
        $this->sessionManager->getClanData();

        // Рассылаем план по всем пользователям
        $this->sendToEveryone($package);
    }

    private function planDelete( TcpConnection $connection, SocketPackage $package ) {
        // Понимаем, что это план (??)

        // Тут должна быть проверка плана на валидность

        // Высосываем план из базы данных

        // Рассылаем команду всем пользователям
        $this->sendToEveryone($package);
    }

    private function sendToEveryone( SocketPackage $package ){
        /** @var TcpConnection $connect */
        foreach ($this->worker->connections as $connect){
            $connect->send( $package->getJson() );
        }
    }



}