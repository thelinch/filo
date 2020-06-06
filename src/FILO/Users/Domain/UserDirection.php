<?php

namespace Filo\Users\Domain;

use src\Shared\Domain\ValueObject\StringValueObject;

class UserDirection extends StringValueObject
{

    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
