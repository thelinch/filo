<?php

namespace Filo\Users\Domain;

use src\Shared\Domain\ValueObject\StringValueObject;
use src\Shared\Domain\ValueObject\Uuid;

class UserId extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
