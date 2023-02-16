<?php

declare(strict_types=1);

namespace App\Helpers;

use Psr\Container\ContainerInterface;

class Auth
{
    protected ContainerInterface $dc;

    public function __construct(ContainerInterface $container) 
    {
        $this->dc = $container;
    }

    public function Login(): void
    {
        
    }
}
