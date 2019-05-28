<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 09.03.2019
 * Time: 16:42
 */

namespace eduslim\application\controller;

use eduslim\domain\user\User;
use eduslim\domain\user\UserManager;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Psr\Log\LoggerInterface;
use Projek\Slim\Plates;

class IntroController
{
    /** @var  LoggerInterface */
    protected $logger;

    /** @var Plates */
    protected $renderer;

    /** @var  UserManager */
    //protected $userManager;

    /**
     * IntroController constructor.
     * @param LoggerInterface $logger
     * @param Plates $renderer
     * @param UserManager $userManager
     */
    public function __construct(LoggerInterface $logger, Plates $renderer)
    {
        $this->logger = $logger;
        $this->renderer = $renderer;
        //$this->userManager = $userManager;
    }


    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        //// TODO: Implement __invoke() method.

        $args['user'] = $request->getAttribute("user");

        //$this->logger->notice($args['user']);

        $this->renderer->addData($args);
        $this->renderer->render( 'index' , $args );

    }

}