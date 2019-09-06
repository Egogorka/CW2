<?php


namespace eduslim\domain\clan;

use eduslim\domain\ServiceException;

use eduslim\domain\session\ClanData;
use eduslim\domain\session\Session;
use eduslim\infrastructure\Color\RGB;

use eduslim\interfaces\domain\clan\ClanInterface;
use eduslim\interfaces\domain\clan\ClanManagerInterface;
use eduslim\interfaces\domain\maps\MapsManagerInterface;
use eduslim\interfaces\domain\sessions\SessionManagerInterface;
use eduslim\interfaces\domain\user\UserInterface;
use eduslim\interfaces\domain\user\UserManagerInterface;

class ClanService
{

    protected $methods = [
            "addUser",
            "removeUser",
            "createSession",
            "addClan"
        ];

    /** @var ClanManagerInterface  */
    protected $clanManager;

    /** @var UserManagerInterface  */
    protected $userManager;

    /** @var MapsManagerInterface  */
    //protected $mapsManager;

    /** @var SessionManagerInterface */
    protected $sessionManager;

    public function __construct(ClanManagerInterface $clanManager, UserManagerInterface $userManager, SessionManagerInterface $sessionManager)
    {
        $this->userManager = $userManager;
        $this->clanManager = $clanManager;
        $this->sessionManager = $sessionManager;
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

        if(!empty($user->getClanId())) {
            throw new ServiceException("User is already in clan");
        }

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

    /**
     * @throws ServiceException
     */
    protected function createSession( ClanInterface $clan, array $args)
    {
        $session = new Session();

        //dump($args);

        if( empty($args["map"]))
            throw new ServiceException("Map is wrong/No such map");

        if( strlen($args["sessionName"]) < 3 )
            throw new ServiceException("Session name is too short");

        // There is a problem.
        // I can test if there is a clan color, but if there would be more?
        if( $args['clanColor'] === null)
            throw new ServiceException("Clan color is unset");

        $session->setName($args['sessionName']);
        $session->setMap($args['map']);
        $session->setMapStateR($session->getMap()->getMapR());

        if( !$this->sessionManager->save($session) )
            throw new ServiceException("Database error, couldnt save session");

        $rgb = new RGB();
        $rgb->getFromHEX($args['clanColor']);
        $hsv = $rgb->getHSV();
        $colorIndex = (round($hsv->getHue() / 60) % 6) + 1;

        $data = new ClanData();
        $data->setProp("color",$colorIndex);

        if($this->sessionManager->addClan($session, $clan) && $this->sessionManager->setClanData($session, $clan, $data))
            throw new ServiceException("Database error, couldnt add clan to the session");

        return true;
    }

    /** @throws ServiceException */
    protected function AddClan(ClanInterface $clan, array $args)
    {
        if(!$session = $this->sessionManager->findByName($args['sessionName']))
            throw new ServiceException("No such session");

        if(!$addClan = $args['addClan'])
            throw new ServiceException("No such clan");

        //dump($addClan);

        if($args['clanColor'] === null)
            throw new ServiceException("Clan color is not set");


        // Actual Adding
        if(!$this->sessionManager->addClan($session, $addClan))
            throw new ServiceException("Database error : couldnt add clan to a session");

        //Color identification
        $rgb = new RGB();
        $rgb->getFromHEX($args['clanColor']);
        $hsv = $rgb->getHSV();
        $colorIndex = (round($hsv->getHue() / 60) % 6) + 1;

        $data = new ClanData();
        $data->setProp("color",$colorIndex);

        if(!$this->sessionManager->setClanData($session, $addClan, $data))
            throw new ServiceException("Database error : cant assign data to the clan in a session");

        return true;
    }



}