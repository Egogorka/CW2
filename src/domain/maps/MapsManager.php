<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 25.03.2019
 * Time: 18:22
 */

namespace eduslim\domain\maps;


use Atlas\Pdo\Connection;
use eduslim\domain\user\UserDao;
use eduslim\interfaces\domain\maps\MapInterface;
use eduslim\interfaces\domain\maps\MapsManagerInterface;
use Psr\Log\LoggerInterface;

class MapsManager implements MapsManagerInterface
{

    /** @var LoggerInterface */
    protected $logger;

    /** @var MapsDao */
    protected $mapsDao;

    /** @var UserDao */
    protected $userDao;

    /**
     * UserManager constructor.
     * @param LoggerInterface $logger
     * @param Connection $connection
     */
    public function __construct(LoggerInterface $logger, MapsDao $mapsDao, UserDao $userDao)
    {
        $this->logger     = $logger;
        $this->mapsDao    = $mapsDao;
        $this->userDao    = $userDao;
    }

    protected function AssignCreator(MapInterface $map):MapInterface
    {
        $map->setCreator($this->userDao->findById($map->getCreatorId()));
        return $map;
    }

    public function findById(int $id):?MapInterface
    {
        return $this->AssignCreator($this->mapsDao->findById($id));
    }

    public function findByName(?string $name):?MapInterface
    {
        return $this->AssignCreator($this->mapsDao->findByName($name));
    }

    public function findAll():?array
    {
        $maps = $this->mapsDao->findAll();
        foreach($maps as &$map){
            $this->AssignCreator($map);
        }
        return $maps;
    }



}