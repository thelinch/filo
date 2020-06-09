<?php

namespace Filo\Transactions\Domain;

use src\Shared\Domain\ValueObject\StringValueObject;
use src\Shared\Domain\ValueObject\Uuid;

class TransactionId extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
