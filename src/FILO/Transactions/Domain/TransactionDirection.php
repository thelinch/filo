<?php

namespace Filo\Transactions\Domain;

use src\Shared\Domain\ValueObject\StringValueObject;

class TransactionDirection extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
