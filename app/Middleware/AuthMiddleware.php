<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Slim\Exception\NotFoundException;

class AuthMiddleware
{
    protected ContainerInterface $dc;

    public function __construct(ContainerInterface $container)
    {
        $this->dc = $container;
    }

    public function __invoke(Request $request, Response $response, callable $next): Response
    {
        $logged_in = (!empty($_SESSION['user']) && $this->dc->get('Users')->getByID((int)$_SESSION['user'])) ? true : false;
        
        if ($logged_in) {
            return $response = $next($request, $response);
        } else {
            return $response->withRedirect($this->dc->router->pathFor('login'));
        }
    }
}
