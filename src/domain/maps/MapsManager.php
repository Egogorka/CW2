<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 25.03.2019
 * Time: 18:22
 */

namespace eduslim\domain\maps;


use Atlas\Pdo\Connection;
use Psr\Log\LoggerInterface;

class MapsManager
{

    /** @var  LoggerInterface */
    protected $logger;

    /** @var  Connection */
    protected $connection;

    /**
     * UserManager constructor.
     * @param LoggerInterface $logger
     * @param Connection $connection
     */
    public function __construct(LoggerInterface $logger, Connection $connection)
    {
        $this->logger     = $logger;
        $this->connection = $connection;
    }

    public function findById($id):?Map
    {
        if ($result = $this->connection->fetchObject( 'SELECT * FROM maps WHERE id=:id', ['id' => $id], Map::class)) {
            return $result;
        }
        return null;
//        if ($result = $this->connection->fetchOne("SELECT * FROM maps WHERE username=:username",['username' => $name])) {
//            $map = new Map();
//            $map->setName($name);
//            $map->setId($result['id']);
//            $map->setCreator( $this->userManager->findById($result['creator']) );
//            return $map;
//        }
    }

    public function findByName($name):?Map
    {
        if ($result = $this->connection->fetchObject( 'SELECT * FROM maps WHERE username=:username', ['name' => $name], Map::class)) {
            return $result;
        }
        return null;
//        if ($result = $this->connection->fetchOne("SELECT * FROM maps WHERE username=:username",['username' => $name])) {
//            $map = new Map();
//            $map->setName($name);
//            $map->setId($result['id']);
//            $map->setCreator( $this->userManager->findById($result['creator']) );
//            return $map;
//        }
//        return null;
    }

    public function findAll():?array
    {
        return $this->connection->fetchObjects('SELECT * FROM maps', [], Map::class);
    }



}