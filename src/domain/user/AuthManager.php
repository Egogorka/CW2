<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 25.03.2019
 * Time: 16:00
 */

namespace eduslim\domain\user;

use Psr\Log\LoggerInterface;

class AuthManager
{
    const NO_USER = 1;
    const WRONG_PASS = 2;

    const USER_EXISTS = 3;
    const SMALL_PASS  = 4;
    const BIG_PASS    = 5;

    /** @var UserManager */
    protected $userManager;

    /** @var LoggerInterface */
    protected $logger;

    public function __construct(LoggerInterface $logger ,UserManager $userManager)
    {
        $this->userManager = $userManager;
        $this->logger      = $logger;
    }

    /**
     * @param string $username
     * @param string $password
     * @throws \Exception
     */
    public function login(string $username, string $password)
    {

        $dbUser = $this->userManager->findByName($username);

        if (is_null($dbUser)){
            throw new \Exception('No such user', self::NO_USER);
        }

        if ( !password_verify($password, $dbUser->getPassHash())){
            throw new \Exception('Wrong password', self::WRONG_PASS);
        }

        // Можем честно сказать, что это он
        $_SESSION['user-id'] = $dbUser->getId();
        return true;
    }


    /**
     * @param string $username
     * @param string $password
     * @throws \Exception
     */
    public function signUp(string $username, string $password, string $email)
    {

        //dump($username, $password);

        $dbUser = $this->userManager->findByName($username);

        if (!is_null($dbUser)){
            throw new \Exception('Such user already exists', self::USER_EXISTS);
        }

        if (strlen($password) < 7 ){
            throw new \Exception('Small password. Must be bigger than 7 symbols',self::SMALL_PASS);
        }

        if (strlen($password) > 63){
            throw new \Exception('That password is too big, man! Must be shorter!', self::BIG_PASS);
        }

        if (strlen($email) < 5){
            throw new \Exception('Email is too short!', self::SMALL_PASS);
        }

        $user = new User();

        $user->setUsername($username);
        $user->setPassHash(password_hash($password, PASSWORD_DEFAULT));
        $user->setEmail($email);

        if( !$this->userManager->save($user) ) {
            throw new \Exception('Database error');
        }

        // Можем честно сказать, что это он
        $_SESSION['user-id'] = $user->getId();
    }
}