<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes


// Main
$app->get('/[index.php]', \eduslim\application\controller\IntroController::class);

// Auth
$app->map(['GET','POST'],'/auth/[{type}/[{name}/[{password}]]]' , \eduslim\application\controller\AuthController::class);

// Maps
$app->get('/maps/', \eduslim\application\controller\MapsController::class);

// Clans
$app->map(['GET','POST'], '/clans/[{type}]', \eduslim\application\controller\ClansController::class);

// When you are logged
$app->group('', function (\Slim\App $app) {

    // When you are in a clan
    $app->group('', function (\Slim\App $app){

        // Clan
        $app->get('/clan/{clanId}', \eduslim\application\controller\ClanController::class );
        $app->get('/clan/{clanId}/leader/{type}/', \eduslim\application\controller\ClanController::class );

        // Sessions

        //$app->get('/session/{id}', SessionController::class);
        //$app->get(  );

    })->add(function(Request $request, Response $response, callable $next){

        /** @var \eduslim\interfaces\domain\user\UserInterface $user */
        $user = $request->getAttribute('user');
        if( is_null($user->getClan()) )
            return $response->withRedirect('/clans/');
        // BEFORE
        $response = $next($request,$response);
        // AFTER

        return $response;

    });

})->add(function(Request $request, Response $response, callable $next){

    $user = $request->getAttribute('user');
    if (is_null($user))
        return $response->withRedirect('/auth/');

    // BEFORE
    $response = $next($request,$response);
    // AFTER

    return $response;

});


