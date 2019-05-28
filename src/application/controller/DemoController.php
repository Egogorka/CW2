<?php
/**
 * User: ivan
 * Date: 24.02.19
 * Time: 0:21
 */

namespace eduslim\application\controller;

use eduslim\domain\user\User;
use eduslim\domain\user\UserManager;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

class DemoController
{
    /** @var  LoggerInterface */
    protected $logger;
    /** @var  PhpRenderer */
    protected $renderer;

    /** @var  UserManager */
    protected $userManager;

    /**
     * IndexController constructor.
     * @param LoggerInterface $logger
     * @param PhpRenderer $renderer
     * @param UserManager $userManager
     */
    public function __construct(LoggerInterface $logger, PhpRenderer $renderer, UserManager $userManager)
    {
        $this->logger = $logger;
        $this->renderer = $renderer;
        $this->userManager = $userManager;
    }


    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {

        $this->userManager->install();

        $q = $this->userManager->findAll();
        dump($q);

        $q = $this->userManager->findById(7);
        if ($q) {
            $q->setUsername('first');
            $q->setPassHash('hash');
            dump($q);
            $this->userManager->save($q);
        }
        $q = $this->userManager->findById(7);
        dump($q);


        $user = new User();
        $user->setUsername('qqq2');
        $user->setPassHash('hhh2');
        dump($user);
        $this->userManager->save($user);
        dump($user);
        // Sample log message

        //echo 'test';

        // Render index view
        return $this->renderer->render($response, 'index.phtml', $args);
    }

}