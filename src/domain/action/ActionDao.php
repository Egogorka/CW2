<?php


namespace eduslim\domain\action;

use eduslim\domain\Dao;
use eduslim\interfaces\domain\action\ActionInterface;

class ActionDao extends Dao
{
    public function findById($id):?ActionInterface
    {
        if ($result = $this->connection->fetchObject( 'SELECT * FROM actions WHERE id=:id', ['id' => $id], Action::class)) {
            return $result;
        }
        return null;
    }

    public function findByName($name):?ActionInterface
    {
        if ($result = $this->connection->fetchObject( 'SELECT * FROM actions WHERE name=:name', ['name' => $name], Action::class)) {
            return $result;
        }
        return null;
    }

    public function findAll():?array
    {
        $result = $this->connection->fetchObjects("SELECT * FROM actions", [], Action::class);
        return $result;
    }

    public function save(Action $action)
    {
        try {
            if ($action->getId()) {
                $this->connection->perform('UPDATE actions SET name=:name, url=:url WHERE id=:id;',
                    [
                        'id' => $action->getId(),
                        'name' => $action->getName(),
                        'url' => $action->getUrl(),
                    ]);
            } else {

                $this->connection->perform('INSERT INTO actions (name, url) VALUES (:name, :url);',
                    [
                        'name' => $action->getName(),
                        'leader_id' => $action->getUrl(),
                    ]);
                $id = $this->connection->lastInsertId();

                $action->setId($id); // do via reflection
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