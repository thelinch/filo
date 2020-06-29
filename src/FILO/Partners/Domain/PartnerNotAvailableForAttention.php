<?php

namespace Filo\Partners\Domain;

use RuntimeException;
use src\Shared\Domain\DomainError;

class PartnerNotAvailableForAttetion extends DomainError
{
    private PartnerId $id;
    public function __construct(PartnerId $id)
    {
        $this->id = $id;
        parent::__construct();
    }
    public function errorCode(): string
    {
        return "partner_not_available";
    }
    protected function errorMessage(): string
    {
        return sprintf("The Partner not available for attention", $this->id->value());
    }
}
