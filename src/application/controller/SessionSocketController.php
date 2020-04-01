<?php


namespace eduslim\application\controller;

use eduslim\domain\clan\ClansManager;
use eduslim\domain\session\ClanData;
use eduslim\domain\session\plans\PlanTemp;
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
    protected $connectionsData; // connectionsData[connection->id]

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

    public function setWorker( Worker $worker )
    {
        $this->worker = &$worker;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param TcpConnection $connection
     */
    public function onConnection( TcpConnection $connection)
    {

    }

    /**
     * @param TcpConnection $connection
     * @param \JsonSerializable|string $rawData
     */
    public function onMessage( TcpConnection $connection, $rawData)
    {
        //$data = json_decode($rawData);
        $package = new SocketPackage();

        $package->setFromJson($rawData);

        echo "Got a message\n";
        dump($connection->id);
        dump($package);

        if( key_exists($connection->id, $this->connectionsData)) // Проверяем, есть ли за коннектом что-то в датах
            $package->setSender($this->connectionsData[$connection->id]->getUser());

        // Calling packet handling methods
        $handler = array($this,$package->getType());
        if( is_callable($handler) )
            $handler($connection, $package);


//        switch ($package->getType()){
//            case SocketPackage::TYPE_VERIFY:
//                $this->verify($connection, $package); break;
//            case SocketPackage::TYPE_MESSAGE:
//                $this->message($connection, $package); break;
//            case SocketPackage::TYPE_PLAN_CREATE:
//                $this->planCreate($connection, $package); break;
//            case SocketPackage::TYPE_PLAN_DELETE:
//                $this->planDelete($connection, $package); break;
//        }
    }

    /**
     * @param TcpConnection $connection
     */
    public function onClose( TcpConnection $connection)
    {

        $sessionId = $this->connectionsData[$connection->id]->getSessionId();
        $clanId = $this->connectionsData[$connection->id]->getClanId();

        if( $key = array_search($this->connections[$sessionId][$clanId], $connection) !== false ){
            unset($this->connections[$sessionId][$clanId][$key]);
        }
        unset($this->connectionsData[$connection->id]);


    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////

    private function getClanData( TcpConnection $connection )
    {
        $data = $this->connectionsData[$connection->id];

        $session = $this->sessionManager->findById($data->getSessionId());
        $clan    = $this->clansManager->findById($data->getClanId());

        return $this->sessionManager->getClanData($session, $clan);
    }

    private function setClanData( TcpConnection $connection, ClanData $data )
    {
        $data = $this->connectionsData[$connection->id];

        $session = $this->sessionManager->findById($data->getSessionId());
        $clan    = $this->clansManager->findById($data->getClanId());

        $this->sessionManager->setClanData($session, $clan, $data);
    }

    private function messageEveryone( SocketPackage $package )
    {
        /** @var TcpConnection $connect */
        foreach ($this->worker->connections as $connect){
            $connect->send($package->getJson());
        }
    }

    private function messageSession( int $sessionId, SocketPackage $package )
    {
        echo "Messaging session: ".$sessionId."\n";
        dump(count($this->connections[$sessionId]));

        foreach ($this->connections[$sessionId] as $clans){
            foreach ($clans as $connect){
                /** @var TcpConnection $connect */
                $connect->send($package->getJson());
            }
        }
    }

    private function messageClan( int $sessionId, int $clanId, SocketPackage $package )
    {
        echo "Messaging clan\n";

        dump(count($this->connections[$sessionId][$clanId]));

        foreach ($this->connections[$sessionId][$clanId] as $connect){
            echo "sent to:";
            dump($connect->id);
            /** @var TcpConnection $connect */
            $connect->send($package->getJson());
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////

    private function verify( TcpConnection $connection, SocketPackage $package )
    {
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
        if(!key_exists($package->getData()->clanId, $this->connections[$package->getData()->sessionId])) {
            $this->connections[$package->getData()->sessionId][$package->getData()->clanId] = [];
        }

        $this->connections[$package->getData()->sessionId][$package->getData()->clanId][$connection->id] = $connection;
        echo "Connections count : ".count($this->connections[$package->getData()->sessionId][$package->getData()->clanId])."\n";

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

        // Send all plans
        $data = $this->getClanData($connection);
        foreach( $data->getPlans() as $plan){
            $packageOut = new SocketPackage(
                SocketPackage::TYPE_PLAN_CREATE,
                json_encode($plan)
            );
            $connection->send($packageOut->getJson());
        }
    }

    private function message( TcpConnection $connection, SocketPackage $package )
    {
        $this->messageClan(
            $this->connectionsData[$connection->id]->getSessionId(),
            $this->connectionsData[$connection->id]->getClanId(),
            $package
        );
    }

    private function planCreate( TcpConnection $connection, SocketPackage $package )
    {
        $plan = PlanTemp::getFromJson($package->getData());

        $data = $this->connectionsData[$connection->id];

        $session = $this->sessionManager->findById($data->getSessionId());
        $clan    = $this->clansManager->findById($data->getClanId());

        $clanData = $this->sessionManager->getClanData($session,$clan);
        $clanData->addPlan($plan);
        $this->sessionManager->setClanData($session,$clan,$clanData);

        // Рассылаем план по всем пользователям
        $this->messageClan($session->getId(), $clan->getId(), $package);
    }

    private function planDelete( TcpConnection $connection, SocketPackage $package )
    {
        // Рассылаем команду всем пользователям
        $this->messageClan(
            $this->connectionsData[$connection->id]->getSessionId(),
            $this->connectionsData[$connection->id]->getClanId(),
            $package
        );
    }

    private function planningEnd( TcpConnection $connection, SocketPackage $package )
    {
        $data = $this->connectionsData[$connection->id];

        $session = $this->sessionManager->findById($data->getSessionId());
        $clan    = $this->clansManager->findById($data->getClanId());

        // Update clanData
        $clanData = $this->sessionManager->getClanData($session, $clan);
        if( $clanData->getPlansStatus() == ClanData::PLANNING_END){
            echo "Already ended planning";
            return;
        }

        $clanData->setPlansStatus(ClanData::PLANNING_END);
        $this->sessionManager->setClanData($session, $clan, $clanData);

        $this->messageSession($session->getId(), $package);

//        // Check if every clan is ready for action
//        $readyClans = $this->sessionManager->getReadyClans($session);
//        $allClans   = $this->sessionManager->getAllClansInSession($session);

//        if( count($readyClans) == count($allClans) ){
//            // do something
//        }
    }

}