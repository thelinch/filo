<?php

namespace Filo\Users\Application\Auth;

use Filo\Users\Domain\JwtAuth;
use Filo\Users\Domain\User;

class AuthUser
{
    private JwtAuth $auth;
    public function __construct(JwtAuth $auth)
    {
        $this->auth = $auth;
    }
    public function __invoke(): User
    {
        return $this->auth->me();
    }
}
