<?php

namespace Filo\Partners\Domain;

use src\Shared\Domain\ValueObject\StringValueObject;

final class PartnerDescription extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
    public function updateDescription(string $value): self
    {
        return new self($value);
    }
}
