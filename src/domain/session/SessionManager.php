<?php


namespace eduslim\domain\session;


use eduslim\domain\maps\MapsDao;
use eduslim\interfaces\domain\action\ActionInterface;
use eduslim\interfaces\domain\clan\ClanInterface;
use eduslim\interfaces\domain\maps\MapInterface;
use eduslim\interfaces\domain\sessions\SessionInterface;
use eduslim\interfaces\domain\sessions\SessionManagerInterface;
use Psr\Log\LoggerInterface;
use eduslim\domain\mapstate\MapState;

class SessionManager implements SessionManagerInterface
{
    /** @var LoggerInterface */
    protected $logger;

    /** @var SessionDao */
    protected $sessionDao;

    /** @var MapsDao */
    protected $mapsDao;

    public function __construct(LoggerInterface $logger, SessionDao $sessionDao, MapsDao $mapsDao)
    {
        $this->logger = $logger;
        $this->sessionDao = $sessionDao;
        $this->mapsDao = $mapsDao;
    }


    protected function AssignObjects(SessionInterface $session){
        $map = $this->mapsDao->findById($session->getMapId());
        $mapState = new MapState($session->getMapStateR());
        $session->setMapState($mapState);
        $session->setMap($map);
        return $session;
    }

    public function addClan(SessionInterface $session, ClanInterface $clan)
    {
        return $this->sessionDao->addClan($session, $clan);
    }

    public function removeClan(SessionInterface $session, ClanInterface $clan)
    {
        return $this->sessionDao->removeClan($session, $clan);
    }

    public function findById(int $id): ?SessionInterface
    {
        return $this->AssignObjects($this->sessionDao->findById($id));
    }

    public function findByName(string $name): ?SessionInterface
    {
        return $this->AssignObjects($this->sessionDao->findByName($name));
    }

    public function findByMap(MapInterface $map): ?array
    {
        // TODO: Implement findByMap() method.
        return [null];
    }

    public function findByAction(ActionInterface $action): ?array
    {
        // TODO: Implement findByAction() method.
        return [null];
    }

    public function setClanData(SessionInterface $session, ClanInterface $clan, ClanData $data)
    {
        return $this->sessionDao->setClanData($session, $clan, $data);
    }

    public function getClanData(SessionInterface $session, ClanInterface $clan): ?ClanData
    {
        return $this->sessionDao->getClanData($session, $clan);
    }

    public function save(SessionInterface $session)
    {
        if(empty($session->getMapId()))
            $session->setMapId($session->getMap()->getId());
        if(empty($session->getMapStateR()))
            $session->setMapStateR($session->getMapState()->ToString());

        return $this->sessionDao->save($session);
    }
}