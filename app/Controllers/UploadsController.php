<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\NotFoundException;

class UploadsController
{
    protected ContainerInterface $dc;

    public function __construct(ContainerInterface $container) {
        $this->dc = $container;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $file = $this->dc->Uploads->getById((int)$args['id']);
        if (!empty($file)) {
            $extension = substr($file['name'], (int)strrpos($file['name'], '.') + 1);
            readfile($this->dc->files->getDir() . DIRECTORY_SEPARATOR. $file['location']);
            return $response->withHeader('Content-Type', $this->dc->files->getMimeTypeByExt($extension));
        } else {
            throw new NotFoundException($request, $response);
        }
    }
}
