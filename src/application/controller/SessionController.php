<?php


namespace eduslim\application\controller;


use eduslim\domain\action\ActionManager;
use eduslim\domain\clan\ClansManager;
use eduslim\domain\user\UserManager;
use eduslim\interfaces\domain\sessions\SessionManagerInterface;
use Projek\Slim\Plates;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class SessionController extends Controller
{

    /** @var UserManager */
    protected $userManager;

    /** @var ClansManager */
    protected $clansManager;

    /** @var SessionManagerInterface */
    protected $sessionManager;

    /** @var ActionManager */
    protected $actionManager;

    public function __construct(LoggerInterface $logger, Plates $renderer, UserManager $userManager, ClansManager $clansManager, SessionManagerInterface $sessionManager, ActionManager $actionManager)
    {
        parent::__construct($logger, $renderer);
        $this->userManager = $userManager;
        $this->clansManager = $clansManager;
        $this->sessionManager = $sessionManager;
        $this->actionManager = $actionManager;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $user = $this->takeUser($request);
        $userClan = $this->clansManager->findById($user->getClanId());

        $session = $this->sessionManager->findById($args['sessionId']);
        $users   = $this->clansManager->getUsersOf($user->getClan());
        $action  = $this->actionManager->findById($session->getActionId());

        $clans = $this->sessionManager->getAllClansInSession($session);
        $readyClans = $this->sessionManager->getReadyClans($session);

        $clanData = [];
        foreach ($clans as $clan){
            $clanData[$clan->getId()] = $this->sessionManager->getClanData($session, $clan);
        }

        $usersOut = [];
        foreach ($users as $user){
            $usersOut[] = [
                "id" => $user->getId(),
                "username" => $user->getUsername(),
                "clanId" => $user->getClanId(),
            ];
        }

        $this->renderer->addData([
            'userClan' => $userClan,
            'session' => $session,
            'action' => $action,

            'clans' => $clans,
            'readyClans' => $clans,
            'clanData' => $clanData,

            'usersJSON' => json_encode($usersOut)
        ]);

        $this->renderer->render('session', $args);

    }
}