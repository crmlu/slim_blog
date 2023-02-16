<?php

declare(strict_types=1);

namespace App\Classes\Controllers;

use Illuminate\Database\Capsule\Manager as Database;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Container as SlimContainer;
use League\Plates\Engine as Views;

class ArticlesController
{
    private Views $view;
    private Database $db;

    public function __construct(SlimContainer $container) {
        $this->db = $container->get('db');
        $this->view = $container->get('view');
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $articles = $this->db->table('articles')->get();
        return $this->view->render('articles', ['articles' => $articles]);
    }
}
