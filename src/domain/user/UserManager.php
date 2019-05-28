<?php
/**
 * User: ivan
 * Date: 24.02.19
 * Time: 3:15
 */

namespace eduslim\domain\user;

use eduslim\domain\clan\ClansDao;
use eduslim\interfaces\domain\clan\ClanInterface;

use eduslim\interfaces\domain\user\UserInterface;

use eduslim\interfaces\domain\user\UserManagerInterface;

class UserManager implements UserManagerInterface
{

    /**
     * @var UserDao $userDao
     * @var ClansDao $clansDao
     */
    protected $userDao;
    protected $clansDao;

    function __construct(UserDao $userDao, ClansDao $clansDao)
    {
        $this->userDao = $userDao;
        $this->clansDao = $clansDao;
    }

    protected function ClanAssign(UserInterface &$user)
    {
        if($Clan = $this->clansDao->findByMember($user))
        {
            $user->setClan($Clan);
            $user->setClanId($Clan->getId());
        }
        return $user;
    }

    function findById(int $id): ?UserInterface
    {
        if( $User = $this->userDao->findById($id) )
        {
            return $this->ClanAssign($User);
        }
        return null;
    }

    function findByName(string $name): ?UserInterface
    {
        if( $User = $this->userDao->findByName($name))
        {
            return $this->ClanAssign($User);
        }
        return null;
    }

    function findByClan(ClanInterface $clan): ?array
    {
        $Users = $this->userDao->findByClan($clan);

        /** @var UserInterface $user */
        foreach ($Users as &$user) {
            $user->setClan($clan);
            $user->setClanId($clan->getId());
        }
        return $Users;
    }

    function findAll(): ?array
    {
        $Users = $this->userDao->findAll();

        /** @var UserInterface $user */
        foreach ($Users as $user){
            $user = $this->ClanAssign($user);
        }
        return $Users;
    }

    function save(UserInterface $user): bool
    {
        return $this->userDao->save($user);
    }

}