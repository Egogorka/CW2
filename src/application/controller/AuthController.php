<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 09.03.2019
 * Time: 17:52
 */

namespace eduslim\application\controller;


use eduslim\domain\user\AuthManager;
use eduslim\domain\user\User;

use Slim\Http\Response;
use Psr\Http\Message\ServerRequestInterface;

use Psr\Log\LoggerInterface;
use Projek\Slim\Plates;

class AuthController
{
    /** @var  LoggerInterface */
    protected $logger;
    /** @var  Plates */
    protected $renderer;
    /** @var  AuthManager */
    protected $authManager;

    function __construct( LoggerInterface $logger, Plates $renderer, AuthManager $authManager )
    {
        $this->logger = $logger;
        $this->renderer = $renderer;
        $this->authManager = $authManager;
    }

    function __invoke(ServerRequestInterface $request, Response $response, array $args)
    {

        $args['user'] = $request->getAttribute("user");

        $post = $request->getParsedBody();

        $type = $args['type'] ?? null;

        switch ($type){
            case 'unlog':

                session_unset();
                session_destroy();
                session_start();

                return $response->withRedirect("/");

                break;

            case 'signup':

                if(!empty($post['username']))
                    return $this->signUp($request, $response, $args);

                $this->renderer->render('signup', $args);

                break;

            default:

                if(!empty($post['username']))
                    return $this->login($request, $response, $args);

                $this->renderer->render('login', $args);

                break;
        }
        return $response;
    }

    function login(ServerRequestInterface $request, Response $response, array $args)
    {
        $post = $request->getParsedBody();

        try {
            $this->authManager->login($post['username'], $post['password']);
            return $response->withRedirect('/');
        } catch (\Exception $e) {
            $args['error'] = $e->getMessage();
        }

        $this->renderer->addData($args);
        return $this->renderer->render('login', $args);
    }

    function signUp(ServerRequestInterface $request, Response $response, array $args)
    {
        $post = $request->getParsedBody();

        //dump($post);

        try {
            $this->authManager->signUp($post['username'], $post['password'], $post['email']);
            return $response->withRedirect('/');
        } catch ( \Exception $e ) {
            $args['error'] = $e->getMessage();
        }

        $this->renderer->addData($args);
        return $this->renderer->render('signup', $args);
    }

}