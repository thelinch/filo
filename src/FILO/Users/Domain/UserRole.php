<?php

namespace Filo\Users\Domain;

use src\Shared\Domain\ValueObject\StringValueObject;

class UserRole extends StringValueObject
{


    public function __construct(string $value)
    {
        parent::__construct($value);
    }
    public function update(string $password)
    {
        return new self($password);
    }
}
