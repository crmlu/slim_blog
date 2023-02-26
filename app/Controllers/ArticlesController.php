<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Validator;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Models\ArticlesModel;
use Slim\Exception\NotFoundException;
use Respect\Validation\Validator as v;

class ArticlesController extends BaseController
{
    protected ArticlesModel $data;
    protected Validator $validator;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->data = $container->get('Articles');
    }

    public function getIndex(Request $request, Response $response): string
    {
        $articles = $this->data->list();
        return $this->view->render('articles', ['articles' => $articles]);
    }

    public function getList(Request $request, Response $response): string
    {
        $articles = $this->data->list();
        return $this->view->render('list', [
            'items'         => $articles,
            'page_title'    => 'Blog posts',
            'create_link'   => 1,
            'create_path'   => 'get-create-article',
            'create_title'  => 'Write new post',
            'edit_path'     => 'get-update-article',
            'delete_path'   => 'delete-article',
            'columns'       => [
                ['column' => 'title', 'name' => 'Title'],
            ],
        ]);
    }

    
    public function getCreate(Request $request, Response $response): string
    {
        return $this->view->render('upsert_article', ['page_title' => 'Create post']);
    }

    public function postCreate(Request $request, Response $response)
    {
        $validation_result = $this->dc->validator->validateArticle($request);

        if (!$validation_result) {
            return $this->view->render('upsert_article', ['page_title' => 'Create post', 'item' => $request->getParsedBody()]);
        }

        $result = $this->data->insert($request->getParsedBody());
        if (!$result) {
            $this->flash->addMessageNow('error', 'Cannot save post');
            return $this->view->render('upsert_article', ['page_title' => 'Create post', 'item' => $request->getParsedBody()]);
        } else {
            $this->flash->addMessage('info', 'Post saved');
            return $response->withRedirect($this->dc->router->pathFor('articles'));
        }
    }

    public function getUpdate(Request $request, Response $response, array $args): string
    {
        $article = $this->data->getByID((int)$args['id']);
        if ($article) {
            return $this->view->render('upsert_article', ['page_title' => 'Update post', 'item' => $article]);
        } else {
            throw new NotFoundException($request, $response);
        }
    }

    public function postUpdate(Request $request, Response $response, array $args)
    {
        $article = $this->data->getByID((int)$args['id']);
        if (!$article) {
            throw new NotFoundException($request, $response);
        } else {
            $validation_result = $this->dc->validator->validateArticle($request);

            if (!$validation_result) {
                return $this->view->render('upsert_article', ['page_title' => 'Update post', 'item' => $article]);
            }

            $result = $this->data->update($request->getParsedBody());
            if ($result) {
                $this->flash->addMessage('info', 'Post updated');
                return $response->withRedirect($this->dc->router->pathFor('get-update-article', ['id'=>$args['id']]));
            } else {
                $this->flash->addMessageNow('error', 'There was an error. Try again');
                return $this->view->render('upsert_article', ['page_title' => 'Update post', 'item' => $article]);
            }
        }
    }

    public function getDelete(Request $request, Response $response, array $args): Response
    {
        $result = $this->data->delete((int)$args['id']);
        if (!$result) {
            $this->flash->addMessage('error', 'Cannot delete post');
            return $response->withRedirect($this->dc->router->pathFor('get-update-article', ['id'=>$args['id']]));
        } else {
            $this->flash->addMessage('info', 'Post deleted');
            return $response->withRedirect($this->dc->router->pathFor('articles'));
        }
    }
}
