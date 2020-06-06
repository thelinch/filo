<?php

namespace Filo\Partners\Domain;

use src\Shared\Domain\ValueObject\StringValueObject;

final class PartnerPhone extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
