<?php

declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app = new Slim\App($settings);

$dc = $app->getContainer();
$dc['db'] = function ($container) {
    $capsule = new Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return $capsule;
};
$dc['view'] = function ($container) {
    $view = new League\Plates\Engine(__DIR__ . '/../App/Classes/Views');
    return $view;
};
$dc['ArticlesController'] = function ($container) {
    return new App\Classes\Controllers\ArticlesController($container);
};

$app->get('/articles', App\Classes\Controllers\ArticlesController::class);
$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->run();
