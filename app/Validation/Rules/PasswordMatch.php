<?php

declare(strict_types=1);

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use App\Models\UsersModel;

final class PasswordMatch extends AbstractRule
{
    private string $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function validate($input): bool
    {
        return password_verify($input, $this->password) ? true : false;
    }
}
