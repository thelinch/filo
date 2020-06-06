<?php

namespace Filo\Transactions\Domain;

use src\Shared\Domain\ValueObject\Uuid;

class TransactionId extends Uuid
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
