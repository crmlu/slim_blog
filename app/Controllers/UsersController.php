<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Models\UsersModel;
use Slim\Exception\NotFoundException;
use Respect\Validation\Validator as v;

class UsersController extends BaseController
{
    protected UsersModel $data;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->data = $container->get('Users');
    }

    public function getList(Request $request, Response $response): string
    {
        $users = $this->data->list();
        return $this->view->render('list', [
            'items'         => $users,
            'page_title'    => 'Users',
            'create_link'   => 1,
            'create_path'   => 'get-create-user',
            'create_title'  => 'Add new user',
            'edit_path'     => 'get-update-user',
            'delete_path'   => 'delete-user',
            'columns'       => [
                ['column' => 'username', 'name' => 'Username'],
                ['column' => 'email', 'name' => 'Email'],
            ],
        ]);
    }

    public function getCreate(Request $request, Response $response): string
    {
        return $this->view->render('upsert_user', ['page_title' => 'Create user']);
    }

    public function postCreate(Request $request, Response $response)
    {
        $validation_result = $this->dc->validator->validateUser($request);
        if (!$validation_result) {
            return $this->view->render('upsert_user', ['page_title' => 'Create user', 'item' => $request->getParsedBody()]);
        }
        $result = $this->data->insert($request->getParsedBody());
        if (!$result) {
            $this->flash->addMessageNow('error', 'Cannot create user');
            return $this->view->render('upsert_user', ['page_title' => 'Create user', 'item' => $request->getParsedBody()]);
        } else {
            $this->flash->addMessage('info', 'User created');
            return $response->withRedirect($this->dc->router->pathFor('users'));
        }
    }

    public function getUpdate(Request $request, Response $response, array $args): string
    {
        $user = $this->data->getByID((int)$args['id']);
        if ($user) {
            return $this->view->render('upsert_user', ['page_title' => 'Update user', 'item' => $user]);
        } else {
            throw new NotFoundException($request, $response);
        }
    }

    public function postUpdate(Request $request, Response $response, array $args)
    {
        $user = $this->data->getByID((int)$args['id']);
        if (!$user) {
            throw new NotFoundException($request, $response);
        } else {
            $validation_result = $this->dc->validator->validateUser($request, false, $user);
            if (!$validation_result) {
                return $this->view->render('upsert_user', ['page_title' => 'Update user', 'item' => $user]);
            }

            $result = $this->data->update($request->getParsedBody());
            if ($result) {
                $this->flash->addMessage('info', 'User updated');
                return $response->withRedirect($this->dc->router->pathFor('get-update-user', ['id'=>$args['id']]));
            } else {
                $this->flash->addMessageNow('error', 'There was an error. Try again');
                return $this->view->render('upsert_user', ['page_title' => 'Update user', 'item' => $user]);
            }
        }
    }

    public function getDelete(Request $request, Response $response, array $args): Response
    {
        if ($_SESSION['user'] == $args['id']) {
            $this->flash->addMessage('error', 'Cannot delete the user that is logged in');
            return $response->withRedirect($this->dc->router->pathFor('users'));
        }
        $result = $this->data->delete((int)$args['id']);
        if (!$result) {
            $this->flash->addMessage('error', 'Cannot delete user');
            return $response->withRedirect($this->dc->router->pathFor('get-update-user', ['id'=>$args['id']]));
        } else {
            $this->flash->addMessage('info', 'User deleted');
            return $response->withRedirect($this->dc->router->pathFor('users'));
        }
    }
}
