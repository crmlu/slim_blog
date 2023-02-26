<?php

declare(strict_types=1);

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

final class EmailAvailableException extends ValidationException
{
    protected $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Email is already in use. Use another one.',
        ],
        self::MODE_NEGATIVE => [
            self::STANDARD => 'Email is available',
        ],
    ];
}