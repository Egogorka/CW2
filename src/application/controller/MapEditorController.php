<?php


namespace eduslim\application\controller;


use eduslim\domain\maps\MapsManager;
use Projek\Slim\Plates;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\Http\Response;

class MapEditorController extends Controller
{
    /** @var MapsManager */
    protected $mapsManager;

    public function __construct(LoggerInterface $logger, Plates $renderer, MapsManager $mapsManager)
    {
        parent::__construct($logger, $renderer);

        $this->mapsManager = $mapsManager;
    }

    public function __invoke(ServerRequestInterface $request, Response $response, array $args)
    {
        $user = $this->takeUser($request);

        $this->renderer->render('mapeditor',$args);
    }


}