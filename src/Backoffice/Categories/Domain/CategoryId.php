<?php

namespace backoffice\Categories\Domain;

use src\Shared\Domain\ValueObject\Uuid;

class CategoryId extends Uuid
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
