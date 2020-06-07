<?php

namespace Filo\Transactions\Domain;

use src\Shared\Domain\ValueObject\StringValueObject;

class TransactionCode extends StringValueObject
{
    private string $prefix = "TO ";
    public function  __construct(string $value)
    {
        parent::__construct($value);
    }
    public function generateCode()
    {
        return $this->prefix . $this->value();
    }
}
