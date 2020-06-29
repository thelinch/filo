<?php

namespace Filo\Users\Domain;

use src\Shared\Domain\DomainError;

class UserUnauthorized extends DomainError
{
    public function __construct()
    {
        parent::__construct();
    }
    public function errorCode(): string
    {
        return "user_unauthorized";
    }
    protected function errorMessage(): string
    {
        return sprintf("user unauthorized");
    }
}
