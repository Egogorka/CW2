<?php


namespace eduslim\domain\clan;


use eduslim\domain\Dao;
use eduslim\domain\user\User;
use eduslim\interfaces\domain\clan\ClanInterface;
use eduslim\interfaces\domain\sessions\SessionInterface;
use eduslim\interfaces\domain\user\UserInterface;

class ClansDao extends Dao
{
    public function findById(int $id):?ClanInterface
    {
        if ($result = $this->connection->fetchObject( 'SELECT * FROM clans WHERE id=:id', ['id' => $id], Clan::class)) {
            return $result;
        }
        return null;
    }

    public function findByName($name):?ClanInterface
    {
        if ($result = $this->connection->fetchObject( 'SELECT * FROM clans WHERE name=:name', ['name' => $name], Clan::class)) {
            return $result;
        }
        return null;
    }

    public function findAll():?array
    {
        $result = $this->connection->fetchObjects("SELECT * FROM clans", [], Clan::class);
        return $result;
    }

    public function findByMember(UserInterface $user):?ClanInterface
    {
        if( $clanId = $user->getClanId() ){
            if( $clan = $this->findById($clanId)){
                return $clan;
            }
        }
        return null;
    }

    public function findBySession(SessionInterface $session):array
    {
        $dbdata = $this->connection->fetchAll("SELECT * FROM sessions_clans WHERE sessionId =:id", ["id" => $session->getId()]);
        $result = array();
        foreach ($dbdata as $item){
            $result[] = $this->findById($dbdata['clanId']);
        }
        return $result;
    }

    public function save(Clan $clan)
    {
        if($leader = $clan->getLeader() ?? null){
            $clan->setLeaderId($leader->getId());
        }

        try {
            if ($clan->getId()) {
                $this->connection->perform('UPDATE clans SET name=:name, leaderId=:leader_id WHERE id=:id;',
                    [
                        'id' => $clan->getId(),
                        'name' => $clan->getName(),
                        'leader_id' => $clan->getLeaderId(),
                    ]);
            } else {

                $this->connection->perform('INSERT INTO clans (name, leaderId) VALUES (:name, :leader_id);',
                    [
                        'name' => $clan->getName(),
                        'leader_id' => $clan->getLeaderId(),
                    ]);
                $id = $this->connection->lastInsertId();

                $clan->setId($id); // todo via reflection
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