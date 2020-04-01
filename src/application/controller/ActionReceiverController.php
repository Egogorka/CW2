<?php


namespace eduslim\application\controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ActionReceiverController //no extension of controller cuz there is no need for that
{
    public function __construct()
    {

    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        // TODO: Implement __invoke() method.

        // we must have in POST some information about action results

        // What we sent to the action



        // What we must have?
        /*
         * PacketExample = [
         *      "action_id" => aid
         *      "session_id" => sid
         *      "results" => [
         *          "winner_clan_id" => cid,
         *          "hexChange" => null // wont implement
         *      ],
         *      "users_modified" => [
         *
         *
         *      ],
         * ]
         *
         */
    }
}