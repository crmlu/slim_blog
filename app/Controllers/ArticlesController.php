<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Models\ArticlesModel;
use Slim\Exception\NotFoundException;

class ArticlesController extends BaseController
{
    protected ArticlesModel $data;

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
            'items'      => $articles,
            'page_title' => 'Blog posts',
            'columns'    => [
                ['column' => 'title', 'name' => 'Title'],
                ['column' => 'content', 'name' => 'Content']
            ],
            'create_link' => 1
        ]);
    }

    public function getUpdate(Request $request, Response $response, array $args)
    {
        $article = $this->data->getByID($args['id']);
        if ($article) {
            return $this->view->render('upsert_article', ['page_title' => 'Update post', 'item' => $article]);
        } else {
            throw new NotFoundException($request, $response);
        }
    }

    public function postUpdate(Request $request, Response $response, array $args)
    {
        $article = $this->data->getByID($args['id']);
        if (!$article) {
            throw new NotFoundException($request, $response);
        } else {
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

    public function getCreate(Request $request, Response $response)
    {
        return $this->view->render('upsert_article', ['page_title' => 'Create post']);
    }

    public function postCreate(Request $request, Response $response)
    {
        $result = $this->data->insert($request->getParsedBody());
        if (!$result) {
            $this->flash->addMessageNow('error', 'Cannot save post');
            return $this->view->render('upsert_article', ['page_title' => 'Create post', 'item' => $request->getParsedBody()]);
        } else {
            $this->flash->addMessage('info', 'Post saved');
            return $response->withRedirect($this->dc->router->pathFor('articles'));
        }
    }

    public function getDelete(Request $request, Response $response, array $args)
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
