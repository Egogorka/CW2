<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 04.04.2019
 * Time: 22:28
 */

namespace eduslim\application\controller;


use eduslim\interfaces\domain\user\UserInterface;
use Projek\Slim\Plates;
use Psr\Log\LoggerInterface;

use Psr\Http\Message\ServerRequestInterface;

class Controller
{

    /** @var LoggerInterface */
    protected $logger;

    /** @var Plates */
    protected $renderer;

    public function __construct(LoggerInterface $logger, Plates $renderer)
    {
        $this->renderer = $renderer;
        $this->logger   = $logger;
    }

    /** @return UserInterface */
    protected function takeUser(ServerRequestInterface $request)
    {
        $user = $request->getAttribute('user');
        $this->renderer->addData(['user' => $user]);
        return $user;
    }
}