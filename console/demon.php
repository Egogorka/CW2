<?php

require __DIR__ . '/../vendor/autoload.php';
use Workerman\Worker;

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}



// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

$container = $app->getContainer();
//
///**
// * @var \Workerman\Connection\TcpConnection[] $users
// */
//$users = [];
//
//// создаём ws-сервер, к которому будут подключаться все наши пользователи
//$ws_worker = new Worker("websocket://0.0.0.0:8000");
//// создаём обработчик, который будет выполняться при запуске ws-сервера
//$ws_worker->onWorkerStart = function() use (&$users)
//{
//    // создаём локальный tcp-сервер, чтобы отправлять на него сообщения из кода нашего сайта
//    $inner_tcp_worker = new Worker("tcp://127.0.0.1:1234");
//    // создаём обработчик сообщений, который будет срабатывать,
//    // когда на локальный tcp-сокет приходит сообщение
//    $inner_tcp_worker->onMessage = function($connection, $data) use (&$users) {
//        $data = json_decode($data);
//        // отправляем сообщение пользователю по userId
//        if (isset($users[$data->user])) {
//            $webconnection = $users[$data->user];
//            $webconnection->send($data->message);
//        }
//    };
//    $inner_tcp_worker->listen();
//};
//
//$ws_worker->onConnect = function($connection) use (&$users)
//{
//    $connection->onWebSocketConnect = function($connection) use (&$users)
//    {
//        // при подключении нового пользователя сохраняем get-параметр, который же сами и передали со страницы сайта
//        $users[$_GET['user']] = $connection;
//        // вместо get-параметра можно также использовать параметр из cookie, например $_COOKIE['PHPSESSID']
//    };
//};
//
//$ws_worker->onClose = function($connection) use(&$users)
//{
//    // удаляем параметр при отключении пользователя
//    $user = array_search($connection, $users);
//    unset($users[$user]);
//};

$ws_worker = new Worker("websocket://erem.sesc2018.dev.sesc-nsu.ru:8000");

/** @var \eduslim\application\controller\SocketController $wsController */
$wsController = $container->get(\eduslim\application\controller\SocketController::class);
$wsController->setWorker($ws_worker);

/** @var \eduslim\domain\user\UserManager $userManager */
$userManager = $container->get(\eduslim\domain\user\UserManager::class);

/** @var \Workerman\Connection\TcpConnection $connection*/
$ws_worker->onConnect = function($connection) use (&$wsController) {
    $wsController->onConnection($connection);
};

/** @var \Workerman\Connection\TcpConnection $connection
 *  @var mixed $data */
$ws_worker->onMessage = function($connection, $data) use (&$wsController) {
    $wsController->onMessage($connection, $data);
};
//$ws_worker->onClose = function($connection) use (&$wsController) {
//    $wsController->onClose($connection);
//};

// Run worker
Worker::runAll();




