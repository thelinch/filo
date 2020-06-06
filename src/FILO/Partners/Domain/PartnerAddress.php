<?php

namespace Filo\Partners\Domain;

use src\Shared\Domain\ValueObject\StringValueObject;

final class PartnerAddress extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
    public function updateAddress(string $value): self
    {
        return new self($value);
    }
}
