<?php

$dependencies_arr['view'] = function ($container) {
    $view = new League\Plates\Engine(realpath(__DIR__ . '/App/Views'));
    $view->addData([
        'router' => $container->router,
        'cur_uri' => $container->request->getUri()->getBasePath() . '/' . $container->request->getUri()->getPath(),
        'flash' => $container->flash
    ]);
    return $view;
};

$dependencies_arr['db'] = function ($container) {
    $dsn = 'mysql:host=' . $container['settings']['db']['host']
        . ';dbname=' . $container['settings']['db']['database']
        . ';charset=' . $container['settings']['db']['charset'];
    $pdo = new PDO($dsn, $container['settings']['db']['username'], $container['settings']['db']['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$dependencies_arr['ArticlesController'] = function ($container) {
    return new App\Controllers\ArticlesController($container);
};

$dependencies_arr['Articles'] = function ($container) {
    return new App\Models\ArticlesModel($container);
};

$dependencies_arr['Users'] = function ($container) {
    return new App\Models\UsersModel($container);
};

$dependencies_arr['flash'] = function () {
    return new Slim\Flash\Messages();
};

$dependencies_arr['validator'] = function ($container) {
    return new App\Helpers\Validator($container);
};
