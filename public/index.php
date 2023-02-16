<?php

declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

use App\Middleware\AuthMiddleware;

$app = new Slim\App($settings);

$container = $app->getContainer();

foreach ($dependencies_arr as $key => $code) {
    $container[$key] = $code;
}

$app->group('', function () {
    $this->get('/login', App\Controllers\AuthController::class . ':getLogin')->setName('login');
    $this->post('/login', App\Controllers\AuthController::class . ':postLogin')->setName('post-login');
    $this->get('/logout', App\Controllers\AuthController::class . ':getLogout')->setName('logout');
    $this->get('/posts/create', App\Controllers\ArticlesController::class . ':getCreate')->setName('get-create-article');
    $this->post('/posts/create', App\Controllers\ArticlesController::class . ':postCreate')->setName('post-create-article');
    $this->get('/posts/delete/{id}', App\Controllers\ArticlesController::class . ':getDelete')->setName('delete-article');
    $this->get('/posts/{id}', App\Controllers\ArticlesController::class . ':getUpdate')->setName('get-update-article');
    $this->post('/posts/{id}', App\Controllers\ArticlesController::class . ':postUpdate')->setName('post-update-article');
    $this->get('/posts', App\Controllers\ArticlesController::class . ':getList')->setName('articles');
})->add(new AuthMiddleware($container));
$app->get('/', App\Controllers\ArticlesController::class . ':getIndex')->setName('home');

$app->run();
