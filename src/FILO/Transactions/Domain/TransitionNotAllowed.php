<?php

namespace Filo\Transactions\Domain;

use src\Shared\Domain\DomainError;

class TransitionNotAllowed extends DomainError
{

    public function errorCode(): string
    {
        return "transition_not_allowed";
    }
    protected function errorMessage(): string
    {
        return sprintf("The Transition does not allowed");
    }
}
