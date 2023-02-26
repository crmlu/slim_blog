<?php

declare(strict_types=1);

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

final class PasswordMatchException extends ValidationException
{
    protected $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Passwords does not match.',
        ],
        self::MODE_NEGATIVE => [
            self::STANDARD => 'Password ok',
        ],
    ];
}