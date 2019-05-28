<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 25.03.2019
 * Time: 18:24
 */

namespace eduslim\application\controller;


use eduslim\domain\maps\MapsManager;

use Projek\Slim\Plates;
use Psr\Log\LoggerInterface;


use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;


class MapsController
{
    /** @var  LoggerInterface */
    protected $logger;

    /** @var Plates */
    protected $renderer;

    /** @var MapsManager */
    protected $mapsManager;

    public function __construct(LoggerInterface $logger, Plates $renderer, MapsManager $mapsManager)
    {
        $this->renderer     = $renderer;
        $this->logger       = $logger;
        $this->mapsManager  = $mapsManager;
    }

    public function __invoke(ServerRequestInterface $request, Response $response, array $args)
    {
        $args['user'] = $request->getAttribute('user');

        $maps = $this->mapsManager->findAll();
        $args['maps'] = $maps;

        $this->renderer->addData($args);
        $this->renderer->render("maps", $args);
    }

}