<?php


namespace eduslim\application\controller;


use eduslim\domain\clan\ClansManager;
use eduslim\domain\user\UserManager;
use eduslim\interfaces\domain\sessions\SessionManagerInterface;
use Projek\Slim\Plates;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Sessions\SessionsManager;

class SessionController extends Controller
{

    /** @var UserManager */
    protected $userManager;

    /** @var ClansManager */
    protected $clansManager;

    /** @var SessionManagerInterface */
    protected $sessionManager;

    public function __construct(LoggerInterface $logger, Plates $renderer, UserManager $userManager, ClansManager $clansManager, SessionManagerInterface $sessionManager)
    {
        parent::__construct($logger, $renderer);
        $this->userManager = $userManager;
        $this->clansManager = $clansManager;
        $this->sessionManager = $sessionManager;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $user = $this->takeUser($request);

        $session = $this->sessionManager->findById($args['sessionId']);
        $this->renderer->addData(['session' => $session]);

        $this->renderer->render('session', $args);
    }
}