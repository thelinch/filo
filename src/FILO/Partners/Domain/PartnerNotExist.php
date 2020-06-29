<?php

namespace Filo\Partners\Domain;

use RuntimeException;
use src\Shared\Domain\DomainError;

class PartnerNotExist extends DomainError
{
    private PartnerId $id;
    public function __construct(PartnerId $id)
    {
        $this->id = $id;
        parent::__construct();
    }
    public function errorCode(): string
    {
        return "course_not_exist";
    }
    protected function errorMessage(): string
    {
        return sprintf("The Partner does not exist", $this->id->value());
    }
}
