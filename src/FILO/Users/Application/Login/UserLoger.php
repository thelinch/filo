<?php

namespace Filo\Users\Application\Login;

use Filo\Users\Domain\JwtAuth;

class UserLoger
{

    private JwtAuth $auth;

    public function __construct(JwtAuth $auth)
    {
        $this->auth = $auth;
    }
    public function __invoke(string $password, string $email): array
    {
        return  $this->auth->login($password, $email);
    }
}
