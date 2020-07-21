<?php

namespace Filo\Partners\Domain;

use src\Shared\Domain\ValueObject\FloatValueObject;

final class PartnerAmountDelivery extends FloatValueObject
{
    public function __construct(float $value)
    {
        parent::__construct($value);
    }
    public function updateAmountDelivery(float $value): self
    {
        return new self($value);
    }
}
