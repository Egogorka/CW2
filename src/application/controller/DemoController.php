<?php
/**
 * User: ivan
 * Date: 24.02.19
 * Time: 0:21
 */

namespace eduslim\application\controller;

use eduslim\domain\user\UserManager;

use Projek\Slim\Plates;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Psr\Log\LoggerInterface;

use eduslim\infrastructure\Color;

class DemoController extends Controller
{

    /** @var  UserManager */
    protected $userManager;

    /**
     * IndexController constructor.
     * @param LoggerInterface $logger
     * @param Plates $renderer
     * @param UserManager $userManager
     */
    public function __construct(LoggerInterface $logger, Plates $renderer , UserManager $userManager)
    {
        parent::__construct($logger, $renderer);

        $this->userManager = $userManager;
    }


    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {

        //$this->userManager->install();

        $q = $this->userManager->findAll();
        dump($q);

        $rgb = new Color\RGB();
        $rgb->getFromHEX("#fe01fe");

        dump($rgb);
        dump($rgb->getHSV());

        // Render index view
        return $this->renderer->render('test', $args);
    }

}