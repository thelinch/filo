<?php

namespace Filo\Categories\Domain;

use src\Shared\Domain\ValueObject\StringValueObject;

class CategoryId extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
