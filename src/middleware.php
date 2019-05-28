<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->add(
    function (ServerRequestInterface $request, ResponseInterface $response, callable $next) {// Sample log message
        $response = $next($request, $response);

        $this->logger->info($request->getMethod() . ' ' . $response->getStatusCode() . ' ' . $request->getServerParams()['REQUEST_URI'] ?? $request->getUri());

        return $response;
    }
);

/// Небольшой комментарий по поводу использования $_SESSION
/// Это не очень удобно, так как фактически, мы никак себя не ограничиваем в его использовании
/// и можем делать с ним, что хотим и когда хотим
///
/// Но чтобы не заморачиваться, скажу, что есть
///   $_SESSION("user-id") - айди юзера, int
/// Обновляю я его, когда работает контроллер AuthController
/// А гляжу в него только из контроллеров и мидлварей

$app->add( // Мидлварь проверки юзера
    function (ServerRequestInterface $request, ResponseInterface $response, callable $next) {

        /** @var \eduslim\domain\user\UserManager $userManager */
        $userManager = $this->get(\eduslim\domain\user\UserManager::class);

        /** @var \eduslim\domain\clan\ClansManager $clanManager */
        //$clanManager = $this->get(\eduslim\domain\clan\ClansManager::class);

        if (!empty($_SESSION["user-id"])) {

            $user = $userManager->findById($_SESSION["user-id"]);

            //$clan = $clanManager->findById($user->getClanId() ?? null);
            //$user->setClan($clan);

            $request = $request->withAttribute("user", $user);

        } else
            $request = $request->withAttribute("user", null);

        $response = $next($request, $response);

        return $response;
    }
);
