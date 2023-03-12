<?php

declare(strict_types=1);

namespace App\Helpers;

use Slim\Http\Request;
use Psr\Container\ContainerInterface;

class Auth
{
    protected ContainerInterface $dc;

    public function __construct(ContainerInterface $container) {
        $this->dc = $container;
    }

    public function check(): bool
    {
        if (!empty($_SESSION['user']) && $this->dc->get('Users')->getByID((int)$_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }
}
