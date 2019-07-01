<?php


namespace eduslim\domain\session;


use eduslim\domain\BaseException;
use eduslim\domain\Dao;
use eduslim\interfaces\domain\action\ActionInterface;
use eduslim\interfaces\domain\clan\ClanInterface;
use eduslim\interfaces\domain\maps\MapInterface;
use eduslim\interfaces\domain\sessions\SessionInterface;

class SessionDao extends Dao
{
    public function findById(int $id):?SessionInterface
    {
        if ($result = $this->connection->fetchObject( 'SELECT * FROM sessions WHERE id=:id', ['id' => $id], Session::class)) {
            return $result;
        }
        return null;
    }

    public function findByName(string $name):?SessionInterface
    {
        if ($result = $this->connection->fetchObject('SELECT * FROM sessions WHERE name=:name',['name' => $name], Session::class)) {
            return $result;
        }
        return null;
    }

    public function findByMap( MapInterface $map):?array
    {
        return $this->connection->fetchObjects('SELECT * FROM sessions WHERE mapId=:mapId', ['mapId' => $map->getId()], Session::class);
    }

    public function findByAction( ActionInterface $action ):?array
    {
        return $this->connection->fetchObjects('SELECT * FROM sessions WHERE actionId=:actionId', ['actionId' => $action->getId()], Session::class);
    }

    public function findByClan( ClanInterface $clan):array
    {
        $dbdata = $this->connection->fetchAll("SELECT * FROM sessions_clans WHERE clanId =:id", ["id" => $clan->getId()]);
        $result = array();
        foreach ($dbdata as $item){
            $result[] = $this->findById($item['sessionId']);
        }
        return $result;
    }

    public function addClan( SessionInterface $session, ClanInterface $clan )
    {
        try {
            $this->connection->perform('INSERT INTO sessions_clans (sessionId, clanId) VALUES (:sessionId, :clanId);',
                [
                    'sessionId' => $session->getId(),
                    'clanId' => $clan->getId()
                ]);
            return true;
        } catch (\PDOException $e) {
            $this->logger->error($e->getMessage(), [
                'trace' => $e->getTrace(),
            ]);
            return false;
        }
    }

    public function removeClan( SessionInterface $session, ClanInterface $clan)
    {
        try {
            $this->connection->perform('DELETE * FROM sessions_clans WHERE (sessionId=:sessionId, clanId=:clanId)', [
                'clanId' => $clan->getId(),
                'sessionId' => $session->getId()
            ]);
            return true;
        } catch (\PDOException $e) {
            $this->logger->error($e->getMessage(), [
                'trace' => $e->getTrace(),
            ]);
            return false;
        }
    }

    public function setClanData( SessionInterface $session, ClanInterface $clan, ClanData $data)
    {
        try {
            $this->connection->perform('UPDATE sessions_clans SET clanInfo=:clanData WHERE (sessionId=:sessionId, clanId=:clanId)',
                [
                    'clanId' => $clan->getId(),
                    'sessionId' => $session->getId(),
                    'clanData' => $data->toJSON()
                ]);
            return true;
        } catch (\PDOException $e) {
            $this->logger->error($e->getMessage(), [
                'trace' => $e->getTrace(),
            ]);
            return false;
        }
    }

    public function getClanData( SessionInterface $session, ClanInterface $clan):?ClanData
    {
        $result = $this->connection->fetchOne('SELECT * FROM sessions_clans WHERE (sessionId=:sessionId, clanId=:clanId)',
                [
                    'clanId' => $clan->getId(),
                    'sessionId' => $session->getId()
                ]);

        try {
            return new ClanData($result['clanInfo']);
        } catch (BaseException $e){
            $this->logger->error($e->getMessage(), [
                'trace' => $e->getTrace(),
            ]);
            return null;
        }
    }

    public function save( SessionInterface $session ):bool
    {
        try {
            if ($session->getId()) {
                $this->connection->perform('UPDATE sessions SET id=:id, name=:name, mapId=:mapId, actionId=:actionId, mapStateR=:mapStateR  WHERE id=:id;',
                    [
                        'id' => $session->getId(),
                        'name' => $session->getName(),
                        'mapId' => $session->getMapId(),
                        'actionId' => $session->getActionId(),
                        'mapStateR' => $session->getMapStateR()
                    ]);
            } else {
                $this->connection->perform('INSERT INTO sessions (name, mapId, actionId, mapStateR) VALUES (:name, :mapId, :actionId, :mapStateR);',
                    [
                        'name' => $session->getName(),
                        'mapId' => $session->getMapId(),
                        'actionId' => $session->getActionId(),
                        'mapStateR' => $session->getMapStateR()
                    ]);
                $id = $this->connection->lastInsertId();
                $session->setId($id); // via reflection
            }
            return true;

        } catch (\PDOException $e) {
            $this->logger->error($e->getMessage(), [
                'trace' => $e->getTrace(),
            ]);
            return false;
        }
    }
}