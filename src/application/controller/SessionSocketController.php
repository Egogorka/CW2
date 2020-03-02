<?php


namespace eduslim\application\controller;

use eduslim\domain\clan\ClansManager;
use eduslim\domain\session\SessionManager;
use eduslim\domain\sockets\ConnectionData;
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


    /**
     * @var TcpConnection[][][]
     * 1 index : session_id
     * 2 index : clan_id
     * 3 index : connection index
     */
    protected $connections;

    /** @var ConnectionData[] */ //чтобы не сетать самим connection'ам данные
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

    ///////////////////////////////////////////////////////////////////////////////////////////////////////

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

        echo "Got a message\n";
        dump($connection->id);
        dump($package);

        if( key_exists($connection->id, $this->connectionsData)) // Проверяем, есть ли за коннектом что-то в датах
            $package->setSender($this->connectionsData[$connection->id]->getUser());

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

    ///////////////////////////////////////////////////////////////////////////////////////////////////////

    private function messageEveryone( SocketPackage $package ) {
        /** @var TcpConnection $connect */
        foreach ($this->worker->connections as $connect){
            $connect->send($package->getJson());
        }
    }

    private function messageSession( int $sessionId, SocketPackage $package ) {
        foreach ($this->connections[$this->connectionsData[$sessionId]] as $clans){
            foreach ($clans as $connections){
                /** @var TcpConnection $connect */
                foreach ($connections as $connect){
                    $connect->send($package->getJson());
                }
            }
        }
    }

    private function messageClan( int $sessionId, int $clanId, SocketPackage $package ){
        echo "Messaging clan\n";
        dump($package);
        foreach ($this->connections[$sessionId][$clanId] as $connect){
            /** @var TcpConnection $connect */
            $connect->send($package->getJson());
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////

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

        // Add a connection to a connections list
        if(!key_exists($package->getData()->sessionId, $this->connections)) {
            $this->connections[$package->getData()->sessionId] = [];
        }
        if(!key_exists($package->getData()->clanId, $this->connections)) {
            $this->connections[$package->getData()->sessionId][$package->getData()->clanId] = [];
        }

        $this->connections[$package->getData()->sessionId][$package->getData()->clanId][] = $connection;

        // Then add an entry in connectionsData
        $this->connectionsData[$connection->id] = new ConnectionData(
            $this->userManager->findById($package->getData()->userId),
            $package->getData()->sessionId
        );

        $packageOut = new SocketPackage(
            SocketPackage::TYPE_MESSAGE,
            "Hello, " . $this->connectionsData[$connection->id]->getUser()->getUsername()
        );

        $package->setSender($this->userManager->findById($package->getData()->userId));
        $connection->send($packageOut->getJson());
    }

    private function message( TcpConnection $connection, SocketPackage $package ){
        $connection->send($package);
    }

    private function planCreate( TcpConnection $connection, SocketPackage $package ) {
        // TODO: Понимаем, что это план (??)

        // TODO: Тут должна быть проверка плана на валидность

        // Суём план в базу данных
//        $this->sessionManager->getClanData();

        // Рассылаем план по всем пользователям
        $this->messageClan($this->connectionsData[$connection->id]->getClanId(), $package);
    }

    private function planDelete( TcpConnection $connection, SocketPackage $package ) {
        // Понимаем, что это план (??)

        // Тут должна быть проверка плана на валидность

        // Высосываем план из базы данных

        // Рассылаем команду всем пользователям
        $this->messageClan($this->connectionsData[$connection->id]->getClanId(), $package);
    }

}