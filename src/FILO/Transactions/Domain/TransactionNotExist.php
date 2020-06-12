<?php

namespace Filo\Transactions\Domain;

use src\Shared\Domain\DomainError;

class TransactionNotExist extends DomainError
{
    private TransactionId $id;
    public function __construct(TransactionId $id)
    {
        $this->id = $id;
        parent::__construct();
    }
    public function errorCode(): string
    {
        return "transaction_not_exist";
    }
    protected function errorMessage(): string
    {
        return sprintf("The Transaction does not exist", $this->id->value());
    }
}
