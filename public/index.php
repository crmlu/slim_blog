<?php

declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

use App\Middleware\AuthMiddleware;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app = new Slim\App($settings);

$container = $app->getContainer();

$container['db'] = function ($container) {
    $dsn = 'mysql:host=' . $container['settings']['db']['host']
        . ';dbname=' . $container['settings']['db']['database']
        . ';charset=' . $container['settings']['db']['charset'];
    $pdo = new PDO($dsn, $container['settings']['db']['username'], $container['settings']['db']['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$container['view'] = function ($container) {
    $view = new League\Plates\Engine(__DIR__ . '/../App/Views');
    $view->addData([
        'router' => $container->router,
        'uri' => $container->request->getUri(),
        'flash' => $container->flash
    ]);
    // $view->loadExtension(new League\Plates\Extension\URI($_SERVER['ORIG_PATH_INFO']));
    return $view;
};
$container['ArticlesController'] = function ($container) {
    return new App\Controllers\ArticlesController($container);
};
$container['Articles'] = function ($container) {
    return new App\Models\ArticlesModel($container);
};
$container['Users'] = function ($container) {
    return new App\Models\UsersModel($container);
};
$container['flash'] = function () {
    return new Slim\Flash\Messages();
};

$app->group('', function () {
    $this->get('/login', App\Controllers\LoginController::class . ':getLogin')->setName('login');
    $this->post('/login', App\Controllers\LoginController::class . ':postLogin')->setName('post-login');
    $this->get('/logout', App\Controllers\LoginController::class . ':getLogout')->setName('logout');
    $this->get('/posts/create', App\Controllers\ArticlesController::class . ':getCreate')->setName('get-create-article');
    $this->post('/posts/create', App\Controllers\ArticlesController::class . ':postCreate')->setName('post-create-article');
    $this->get('/posts/delete/{id}', App\Controllers\ArticlesController::class . ':getDelete')->setName('delete-article');
    $this->get('/posts/{id}', App\Controllers\ArticlesController::class . ':getUpdate')->setName('get-update-article');
    $this->post('/posts/{id}', App\Controllers\ArticlesController::class . ':postUpdate')->setName('post-update-article');
    $this->get('/posts', App\Controllers\ArticlesController::class . ':getList')->setName('articles');
})->add(new AuthMiddleware($container));
$app->get('/', App\Controllers\ArticlesController::class . ':getIndex')->setName('home');

$app->run();
