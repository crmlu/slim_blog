<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use League\Plates\Engine as Views;
use Slim\Flash\Messages as Flash;

class BaseController
{
    protected ContainerInterface $dc;
    protected Views $view;
    protected Flash $flash;

    public function __construct(ContainerInterface $container) {
        $this->dc = $container;
        $this->view = $container->get('view');
        $this->flash = $container->get('flash');
    }
}
