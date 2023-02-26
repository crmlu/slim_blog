<?php

declare(strict_types=1);

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

final class UsernameAvailableException extends ValidationException
{
    protected $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Username is already in use. Choose another one.',
        ],
        self::MODE_NEGATIVE => [
            self::STANDARD => 'Username is available',
        ],
    ];
}