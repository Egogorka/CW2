<?php

namespace eduslim\domain\sockets;

use eduslim\domain\user\User;
use eduslim\interfaces\domain\user\UserInterface;

class ConnectionData
{
    /** @var User */
    protected $user;

    /** @var integer */
    protected $sessionId;
    // There is no need for it to know about the session itself

    /** @var integer */
    protected $clanId;
    // For easier management

    /**
     * ConnectionData constructor.
     * @param User $user
     * @param integer $sessionId
     */
    public function __construct($user, $sessionId)
    {
        $this->user = $user;
        $this->sessionId = $sessionId;

        $this->clanId = $user->getClanId();
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
        $this->clanId = $user->getClanId();
    }

    /**
     * @return int
     */
    public function getSessionId(): int
    {
        return $this->sessionId;
    }

    /**
     * @param int $sessionId
     */
    public function setSessionId(int $sessionId): void
    {
        $this->sessionId = $sessionId;
    }

    public function getClanId(): int
    {
        return $this->clanId;
    }
}