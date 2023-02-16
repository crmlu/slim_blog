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
        $route = $request->getAttribute('route');
        if (empty($route)) {
            throw new NotFoundException($request, $response);
        }
        
        $logged_in = (!empty($_SESSION['user']) && $this->dc->get('Users')->getByID((int)$_SESSION['user'])) ? true : false;
        $route_name = $route->getName();
        if ($logged_in) {
            switch ($route_name) {
                case 'login':
                case 'post-login':
                    return $response->withRedirect($this->dc->router->pathFor('articles'));
                    break;
                default:
                    return $response = $next($request, $response);
            }
        } else {
            switch ($route_name) {
                case 'login':
                case 'post-login':
                    return $response = $next($request, $response);
                    break;
                default:
                    return $response->withRedirect($this->dc->router->pathFor('login'));
            }
        }
    }
}
