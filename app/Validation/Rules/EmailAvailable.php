<?php

declare(strict_types=1);

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use App\Models\UsersModel;

final class EmailAvailable extends AbstractRule
{
    private UsersModel $model;

    public function __construct(UsersModel $model)
    {
        $this->model = $model;
    }

    public function validate($input): bool
    {
        return empty($this->model->getByEmail($input)) ? true : false;
    }
}
