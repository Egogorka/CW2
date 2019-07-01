<?php


namespace eduslim\domain\maps;


use eduslim\domain\Dao;

class MapsDao extends Dao
{
    public function findById($id):?Map
    {
        if ($result = $this->connection->fetchObject( 'SELECT * FROM maps WHERE id=:id', ['id' => $id], Map::class)) {
            return $result;
        }
        return null;
    }

    public function findByName($name):?Map
    {
        if ($result = $this->connection->fetchObject( 'SELECT * FROM maps WHERE name=:name', ['name' => $name], Map::class)) {
            return $result;
        }
        return null;
    }

    public function findAll():?array
    {
        return $this->connection->fetchObjects('SELECT * FROM maps', [], Map::class);
    }
}