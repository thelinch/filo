<?php

namespace Filo\Transactions\Domain;

use src\Shared\Domain\ValueObject\StringValueObject;

class TransactionPhone extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
