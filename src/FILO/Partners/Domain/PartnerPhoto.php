<?php

namespace Filo\Partners\Domain;

use src\Shared\Domain\ValueObject\StringValueObject;

final class PartnerPhoto extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
