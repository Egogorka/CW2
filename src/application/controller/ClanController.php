<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 01.04.2019
 * Time: 23:01
 */

namespace eduslim\application\controller;


use eduslim\domain\clan\ClanService;
use eduslim\domain\clan\ClansManager;
use eduslim\domain\maps\MapsManager;
use eduslim\domain\ServiceException;
use eduslim\domain\session\SessionManager;
use eduslim\domain\user\UserManager;
use eduslim\interfaces\domain\clan\ClanInterface;
use Projek\Slim\Plates;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\Http\Response;

class ClanController extends Controller
{

    /** @var ClansManager */
    protected $clansManager;

    /** @var UserManager */
    protected $userManager;

    /** @var SessionManager */
    protected $sessionManager;

    /** @var MapsManager */
    protected $mapsManager;

    /** @var ClanService */
    protected $clanService;

    public function __construct(LoggerInterface $logger, Plates $renderer, ClansManager $clansManager, UserManager $userManager /*, SessionManager $sessionManager*/, MapsManager $mapsManager, ClanService $clanService)
    {
        parent::__construct($logger, $renderer);

        $this->userManager = $userManager;
        $this->clansManager = $clansManager;
       // $this->sessionManager = $sessionManager;
        $this->mapsManager = $mapsManager;
        $this->clanService = $clanService;
    }

    public function __invoke(ServerRequestInterface $request, Response $response, array $args)
    {
        $user = $this->takeUser($request); // Get information about current user

        $clan = $args["clan"] = $this->clansManager->findById($args["clanId"] ?? null);

        $this->renderer->addData(["clan" => $clan]);

        if ($user->getId() == $clan->getLeaderId()) {
            $args["clanLeaderBool"] = true;

            if ($args["type"] ?? null) {
                $args = $this->leader($request->getQueryParams(), $clan, $args);
            }

        } else
            $args["clanLeaderBool"] = false;

        $args["clanMembers"] = $this->clansManager->getUsersOf($clan);
        $args["sessions"] = $this->clansManager->getSessionsOf($clan);

        $this->renderer->render("clan", $args);
    }

    protected function leader(array $get, ClanInterface $clan, array $args)
    {
        try {
            $this->clanService->handle($args['type'], $clan,
                array(
                    "user" => (!empty($get['username'])) ? $this->userManager->findByName($get['username']) : null,

                    "sessionName" => $get['sessionName'] ?? null,

                    "map" => (!empty($get["mapName"])) ? $this->mapsManager->findByName($get['mapName']) : null,

                    "action" => null,

                    "addClan" => (!empty($get['addClanName'])) ? $this->clansManager->findByName($get['addClanName']) : null,
                )
            );
        } catch (ServiceException $e){
            $args['error'] = $e->getMessage();
        }

        return $args;

//        switch ($args['type']) {
//            case "addUser":
//                /*if (!$user = $this->userManager->findByName($get['username'])) {
//                    $args['error'] = "No such user";
//                    break;
//                }
//
//                $user->setClanId($clan->getId());
//
//                if (!$this->userManager->save($user)) {
//                    $args['error'] = "Database error";
//                    break;
//                }*/
//                $this->clanService
//
//                break;
//            case "createSession":
//
//                if (!($map = $this->mapsManager->findByName($get['mapName']))) {
//                    $args['error'] = "No such map";
//                    break;
//                }
//                /*
//                if (!($action = $this->actionsManager->findByName($get['actionName']))){
//                    $args['error'] = "No such action";
//                    break;
//                }*/
//
//
//                break;
//        }
    }
}
