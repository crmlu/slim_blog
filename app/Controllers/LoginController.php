<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Models\UsersModel;

class LoginController extends BaseController
{
    protected UsersModel $data;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->data = $container->get('Users');
    }

    public function getLogin(Request $request, Response $response)
    {
        return $this->view->render('login', ['url' => $request->getUri()->getPath()]);
    }
    
    public function postLogin(Request $request, Response $response): Response
    {
        $username = $request->getParam('username');
        $password = $request->getParam('password');
        
        $user = $this->data->getByUsername($username);
        if (empty($user) || !password_verify($password, $user['password'])) {
            $this->flash->addMessage('error', 'Invalid username/password');
            return $response->withRedirect($this->dc->router->pathFor('login'));
        } else {
            $_SESSION['user'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return $response->withRedirect($this->dc->router->pathFor('articles'));
        }
    }

    public function getLogout(Request $request, Response $response)
    {
        unset($_SESSION['user'], $_SESSION['username']);
        // $this->flash->addMessage('info', 'Ok');
        return $response->withRedirect($this->dc->router->pathFor('home'));
    }
}
