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
        if ($this->dc->auth->check()) {
            return $response = $next($request, $response);
        } else {
            return $response->withRedirect($this->dc->router->pathFor('login'));
        }
    }
}
