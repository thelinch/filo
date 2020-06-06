<?php

namespace Filo\Transactions\Domain;

use src\Shared\Domain\ValueObject\FloatValueObject;

class TransactionTotal extends FloatValueObject
{

    public function __construct(float $value)
    {
        parent::__construct($value);
    }
}
