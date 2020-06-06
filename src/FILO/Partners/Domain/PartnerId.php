<?php

namespace Filo\Partners\Domain;

use src\Shared\Domain\ValueObject\StringValueObject;
use src\Shared\Domain\ValueObject\Uuid;

final class PartnerId extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
