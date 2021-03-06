<?php

namespace src\Shared\Domain\Pagination;

use src\Shared\Domain\ValueObject\IntValueObject;

class NumberPerPage extends IntValueObject
{
    public function __construct(int $value)
    {
        parent::__construct($value);
    }
}
