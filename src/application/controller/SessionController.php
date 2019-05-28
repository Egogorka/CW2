<?php


namespace eduslim\application\controller;


use eduslim\domain\clan\ClansManager;
use eduslim\domain\user\UserManager;

class SessionController extends Controller
{

    /** @var UserManager */
    protected $userManager;

    /** @var ClansManager */
    protected $clansManager;


    protected $sessionsManager;
}