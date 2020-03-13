<?php

namespace eduslim\application\controller;


use eduslim\domain\action\ActionManager;
use Projek\Slim\Plates;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\Http\Response;

class ActionsController extends Controller
{

    /** @var ActionManager */
    protected $actionManager;

    public function __construct(LoggerInterface $logger, Plates $renderer, ActionManager $actionManager)
    {
        parent::__construct($logger, $renderer);

        $this->actionManager = $actionManager;
    }

    public function __invoke(ServerRequestInterface $request, Response $response, array $args)
    {
        $this->takeUser($request);
        $args['actions'] =  $this->actionManager->findAll();
        $this->renderer->render("actions",$args);
    }
}