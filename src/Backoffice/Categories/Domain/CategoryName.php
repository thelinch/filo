<?php

namespace backoffice\Categories\Domain;

use src\Shared\Domain\ValueObject\StringValueObject;

class CategoryName extends StringValueObject
{

    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
