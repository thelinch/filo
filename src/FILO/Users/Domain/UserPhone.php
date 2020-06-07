<?php

namespace Filo\Users\Domain;

use src\Shared\Domain\ValueObject\StringValueObject;

class UserPhone extends StringValueObject
{

    public function __construct(string $value)
    {
        parent::__construct($value);
    }
    public function update(string $value)
    {
        return new self($value);
    }
}
