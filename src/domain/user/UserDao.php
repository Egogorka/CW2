<?php


namespace eduslim\domain\user;


use eduslim\domain\Dao;

use eduslim\interfaces\domain\clan\ClanInterface;
use eduslim\interfaces\domain\user\UserInterface;

class UserDao extends Dao
{

    public function findById($id):?UserInterface
    {
        if ($result = $this->connection->fetchObject( 'SELECT * FROM users WHERE id=:id', ['id' => $id], User::class)) {
            return $result;
        }
        return null;
    }

    public function findByName($username):?UserInterface
    {
        if ($result = $this->connection->fetchObject( 'SELECT * FROM users WHERE username=:username', ['username' => $username], User::class)) {
            return $result;
        }
        return null;
    }

    public function findByClan(ClanInterface $clan):?array
    {
        $id = $clan->getId();

        return $this->connection->fetchObjects('SELECT * FROM users WHERE clanId=:id', ['id' => $id], User::class);
    }

    public function findAll():?array
    {
        return $this->connection->fetchObjects('SELECT * FROM users', [], User::class);
    }

    public function save(UserInterface $user)
    {
        try {
            if ($user->getId()) {
                $this->connection->perform('UPDATE users SET username=:username, pass_hash=:password, email=:email, clanId=:clanId WHERE id=:id;',
                    [
                        'id' => $user->getId(),
                        'username' => $user->getUsername(),
                        'password' => $user->getPassHash(),
                        'email' => $user->getEmail(),
                        'clanId' => $user->getClanId(),
                    ]);
            } else {
                $this->connection->perform('INSERT INTO users (username, pass_hash, email) VALUES (:username, :password, :email);',
                    [
                        'username' => $user->getUsername(),
                        'password' => $user->getPassHash(),
                        'email'    => $user->getEmail(),
                    ]);
                $id = $this->connection->lastInsertId();
                $user->setId($id); // todo via reflection
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