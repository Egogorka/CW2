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
        $users   = $this->clansManager->getUsersOf($user->getClan());

        dump($users);
        dump(json_encode($users));

        $this->renderer->addData(['session' => $session]);
        $this->renderer->addData(['usersJSON' => json_encode($users)]);

        $this->renderer->render('session', $args);
    }
}