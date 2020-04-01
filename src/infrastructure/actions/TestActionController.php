<?php


namespace eduslim\infrastructure\actions;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TestActionController
{
    public function __construct()
    {

    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        // Getting the information of players
        $post = $request->getParsedBody();
        // Post structure:
        /*
         * $post ~ [
         *      "user_id" => uid,
         *      "session_id" => sid,
         *      "attack" => attack,
         * ]
         *
         */



    }
}