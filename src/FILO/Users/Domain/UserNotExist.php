<?php

namespace Filo\Users\Domain;

use src\Shared\Domain\DomainError;

class UserNotExist extends DomainError
{
    private UserId $id;
    public function __construct(UserId $id)
    {
        $this->id = $id;
        parent::__construct();
    }
    public function errorCode(): string
    {
        return "user_not_exist";
    }
    protected function errorMessage(): string
    {
        return sprintf("The User does not exist", $this->id->value());
    }
}
