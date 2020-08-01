<?php

namespace Filo\Partners\Domain;

use src\Shared\Domain\ValueObject\IntValueObject;

final class PartnerState extends IntValueObject
{
    public function __construct(int $value)
    {
        parent::__construct($value);
    }
}
