<?php

declare(strict_types=1);

namespace App\Helpers;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;
use Slim\Http\Request;
use Psr\Container\ContainerInterface;
use Slim\Flash\Messages as Flash;
use Respect\Validation\Validator as v;

class Validator
{
    protected bool $have_errors;
    protected ContainerInterface $dc;
    protected Flash $flash;

    public function __construct(ContainerInterface $container) {
        $this->dc = $container;
        $this->flash = $container->get('flash');
        $this->have_errors = false;
    }

    public function validate(Request $request, array $rules): bool
    {
        foreach ($rules as $rule) {
            try {
                $rule['rule']->setName($rule['name'])->assert($request->getParam($rule['field']));
            } catch (NestedValidationException $e) {
                $this->have_errors = true;
                $this->flash->addMessageNow('error', $e->getFullMessage());
            }
        }
        if ($this->have_errors) {
            return false;
        } else {
            return true;
        }
    }

    public function validateArticle(Request $request): bool
    {
        $rules[] = [
            'field' => 'title',
            'name'  => 'Title',
            'rule'  => v::stringType()->length(1, 1000),
        ];
        $rules[] = [
            'field' => 'content',
            'name'  => 'Post',
            'rule'  => v::stringType()->length(1, null),
        ];
        return $this->validate($request, $rules);
    }

    public function validateUser(Request $request, $create = true, array $data = [] ): bool
    {
        $model = $this->dc->Users;
        $rules[] = [
            'field' => 'name',
            'name'  => 'Name',
            'rule'  => v::stringType()->length(1, 100),
        ];
        if ($create || ($data['username'] != $request->getParam('username'))) {
            $rules[] = [
                'field' => 'username',
                'name'  => 'Username',
                'rule'  => v::alnum()->noWhitespace()->length(5, 100)->UsernameAvailable($model),
            ];
        }
        if ($create || ($data['email'] != $request->getParam('email'))) {
            $rules[] = [
                'field' => 'email',
                'name'  => 'Email',
                'rule'  => v::email()->EmailAvailable($model),
            ];
        }
        if ($create) {
            $rules[] = [
                'field' => 'password',
                'name'  => 'Password',
                'rule'  => v::noWhitespace()->notEmpty(),
            ];
            $rules[] = [
                'field' => 'password2',
                'name'  => 'Repeat password',
                'rule'  => v::noWhitespace()->notEmpty()->PasswordMatch(password_hash($request->getParam('password'),PASSWORD_DEFAULT)),
            ];
        } else {
            if (!empty($request->getParam('password')) && password_verify($request->getParam('current_password'), $data['password'])) {
                $rules[] = [
                    'field' => 'password',
                    'name'  => 'Password',
                    'rule'  => v::noWhitespace()->notEmpty(),
                ];
                $rules[] = [
                    'field' => 'password2',
                    'name'  => 'Repeat password',
                    'rule'  => v::noWhitespace()->notEmpty()->PasswordMatch(password_hash($request->getParam('password'),PASSWORD_DEFAULT)),
                ];
            }
        }
        return $this->validate($request, $rules);
    }
}
