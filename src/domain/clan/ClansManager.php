<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 25.03.2019
 * Time: 22:39
 */

namespace eduslim\domain\clan;


use eduslim\domain\session\SessionDao;
use eduslim\domain\user\UserDao;
use eduslim\interfaces\domain\clan\ClanInterface;
use eduslim\interfaces\domain\user\UserInterface;

use eduslim\interfaces\domain\clan\ClanManagerInterface;
use Psr\Log\LoggerInterface;

class ClansManager implements ClanManagerInterface
{
    /** @var LoggerInterface */
    protected $logger;

    /** @var ClansDao */
    protected $clansDao;

    /** @var UserDao */
    protected $userDao;

    /** @var SessionDao */
    protected $sessionDao;

    function __construct(LoggerInterface $logger, UserDao $userDao, ClansDao $clansDao, SessionDao $sessionDao)
    {
        $this->logger = $logger;
        $this->userDao = $userDao;
        $this->clansDao = $clansDao;
        $this->sessionDao = $sessionDao;
    }

    // Id, Leader (not LeaderId) are not set
    public function save(ClanInterface $clan)
    {
        $this->clansDao->save($clan); // <- Id setting and saving
        $user = $this->userDao->findById($clan->getLeaderId());
        $user->setClanId($clan->getId());
        $this->userDao->save($user);
    }

    public function getUsersOf(ClanInterface $clan): ?array
    {
        return $this->userDao->findByClan($clan);
    }

    public function getSessionsOf(ClanInterface $clan): array
    {
        return $this->sessionDao->findByClan($clan);
    }

    protected function AssignObjects(ClanInterface $clan): ClanInterface
    {
        $user = $this->userDao->findById($clan->getLeaderId());
        $clan->setLeader($user);

        return $clan;
    }

    public function findById(int $id): ?ClanInterface
    {
        return $this->AssignObjects($this->clansDao->findById($id));
    }

    public function findByName(string $name): ?ClanInterface
    {
        return $this->AssignObjects($this->clansDao->findByName($name));
    }

    public function findByMember(UserInterface $user): ?ClanInterface
    {
        return $this->AssignObjects($this->clansDao->findByMember($user));
    }

    public function findAll(): ?array
    {
        $clans = $this->clansDao->findAll();
        foreach ($clans as &$clan) {$this->AssignObjects($clan);}
        return $clans;
    }

}