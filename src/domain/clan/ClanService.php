<?php


namespace eduslim\domain\clan;

use eduslim\domain\ServiceException;

use eduslim\interfaces\domain\clan\ClanInterface;
use eduslim\interfaces\domain\clan\ClanManagerInterface;
use eduslim\interfaces\domain\user\UserInterface;
use eduslim\interfaces\domain\user\UserManagerInterface;

class ClanService
{

    protected $methods = [
            "addUser",
            "removeUser",
            "sessionCreate",

        ];

    /** @var ClanManagerInterface  */
    public $clanManager;

    /** @var UserManagerInterface  */
    public $userManager;

    public function __construct(ClanManagerInterface $clanManager, UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
        $this->clanManager = $clanManager;
    }

    /**
     * @param string $methodName
     * @param ClanInterface $clan
     * @param array $args
     * @throws ServiceException
     * @return bool
     */
    public function handle( string $methodName, ClanInterface $clan, array $args){

        //Проверяем, есть ли такой метод у нас в списках
        if( in_array($methodName, $this->methods) ){
            if( call_user_func_array(array($this, $methodName), array($clan, $args))) {
                return true;
            }
        }
        throw new ServiceException("No such method");
    }

    /**
     * @throws ServiceException
     */
    protected function UserTest( ?UserInterface $user )
    {
        /*
        if(empty($user)) return "No user";
        if(empty($user->getId())) return "User has no id";
        return true;*/

        if(empty($user)) {
            throw new ServiceException("No such user");
        }

        if(empty($user->getId())) {
            throw new ServiceException("User has no id");
        }

        return true;
    }

    /**
     * @param ClanInterface $clan
     * @param array $args
     * @return bool
     * @throws ServiceException
     */
    protected function addUser( ClanInterface $clan, array $args )
    {
        $user = $args['user'];

        $this->UserTest($user);

        //if(!empty($user->getClanId())) return "User is already in clan";

        $user->setClanId($clan->getId());

        if(!$this->userManager->save($user)) {
            throw new ServiceException("Could not save the changes of the user");
        }

        return true;
    }

    /**
     * @param ClanInterface $clan
     * @param array $args
     * @return bool
     * @throws ServiceException
     */
    protected function removeUser( ClanInterface $clan, array $args )
    {
        $user = $args['user'];

        $this->UserTest($user);

        if($user->getClanId() != $clan->getId()) {
            throw new ServiceException( "This user is from other clan");
        }

        $user->setClanId(null);

        if(!$this->userManager->save($user)) {
            throw new ServiceException("Database error, couldnt save user");
        }

        return true;
    }






}