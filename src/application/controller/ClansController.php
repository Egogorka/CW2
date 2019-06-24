<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 25.03.2019
 * Time: 20:17
 */

namespace eduslim\application\controller;


use eduslim\domain\clan\Clan;
use eduslim\domain\clan\ClansManager;
use eduslim\domain\user\UserManager;
use eduslim\interfaces\domain\clan\ClanInterface;
use Projek\Slim\Plates;
use Psr\Log\LoggerInterface;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

class ClansController extends Controller
{
    /** @var ClansManager */
    protected $clansManager;

    /** @var UserManager */
    protected $userManager;

    public function __construct(LoggerInterface $logger, Plates $renderer, ClansManager $clansManager, UserManager $userManager)
    {
        parent::__construct($logger, $renderer);

        $this->clansManager = $clansManager;
        $this->userManager = $userManager;
    }

    public function __invoke(ServerRequestInterface $request, Response $response, array $args)
    {
        if( $args['type'] ?? null == 'create'){
            $this->create($request, $response, $args);
        } else {
            $this->main($request, $response, $args);
        }

    }

    protected function create(ServerRequestInterface $request, Response $response, array $args)
    {
        $user = $this->takeUser($request);
        dump($user);

        $post = $request->getParsedBody();

        if( $post["name"] ?? null ) {

            if( !($user ?? null) ){

                $args['error'] = "You should register to create a clan";

            } elseif ( $user->getClanId() ?? null ) {

                $args['error'] = "You cant create another clan";

            } else
            try {

                $clan = new Clan();
                $clan->setLeader($user);
                $clan->setName($post['name']);

                $this->clansManager->save($clan);

            } catch (\Exception $e) {
                $args['error'] = $e->getMessage();
            }
        }

        $this->renderer->render("clancreate", $args);
    }

    protected function   main(ServerRequestInterface $request, Response $response, array $args)
    {
        $this->takeUser($request);

        $clans = $this->clansManager->findAll();

        /** @var ClanInterface $clan */
        foreach ($clans as  &$clan) {

            if ($leader = $this->userManager->findById($clan->getLeaderId())) {
                $clan->setLeader($leader);
            }
        }

        $args['clans'] = $clans;
        $this->renderer->render("clans", $args);

    }

}