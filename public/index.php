<?php

declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use Respect\Validation\Factory;

$app = new Slim\App($settings);

$container = $app->getContainer();

foreach ($dependencies_arr as $key => $code) {
    $container[$key] = $code;
}

Factory::setDefaultInstance(
    (new Factory())
        ->withRuleNamespace('App\\Validation\\Rules')
        ->withExceptionNamespace('App\\Validation\\Exceptions')
);

$app->group('', function () {
    $this->get('/login', App\Controllers\AuthController::class . ':getLogin')->setName('login');
    $this->post('/login', App\Controllers\AuthController::class . ':postLogin')->setName('post-login');
})->add(new GuestMiddleware($container));
$app->group('', function () {
    $this->get('/logout', App\Controllers\AuthController::class . ':getLogout')->setName('logout');
    $this->get('/users/create', App\Controllers\UsersController::class . ':getCreate')->setName('get-create-user');
    $this->post('/users/create', App\Controllers\UsersController::class . ':postCreate')->setName('post-create-user');
    $this->get('/users/delete/{id}', App\Controllers\UsersController::class . ':getDelete')->setName('delete-user');
    $this->get('/users/{id}', App\Controllers\UsersController::class . ':getUpdate')->setName('get-update-user');
    $this->post('/users/{id}', App\Controllers\UsersController::class . ':postUpdate')->setName('post-update-user');
    $this->get('/users', App\Controllers\UsersController::class . ':getList')->setName('users');

    $this->get('/posts/create', App\Controllers\ArticlesController::class . ':getCreate')->setName('get-create-article');
    $this->post('/posts/create', App\Controllers\ArticlesController::class . ':postCreate')->setName('post-create-article');
    $this->get('/posts/delete/{id}', App\Controllers\ArticlesController::class . ':getDelete')->setName('delete-article');
    $this->get('/posts/{id}', App\Controllers\ArticlesController::class . ':getUpdate')->setName('get-update-article');
    $this->post('/posts/{id}', App\Controllers\ArticlesController::class . ':postUpdate')->setName('post-update-article');
    $this->get('/posts', App\Controllers\ArticlesController::class . ':getList')->setName('articles');
})->add(new AuthMiddleware($container));

$app->get('/uploads/{id}/{name}', App\Controllers\UploadsController::class)->setName('uploads');
$app->get('/', App\Controllers\ArticlesController::class . ':getIndex')->setName('home');

$app->run();
