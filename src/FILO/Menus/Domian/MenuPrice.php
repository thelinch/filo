<?php

namespace Filo\Menus\Domain;

use src\Shared\Domain\ValueObject\FloatValueObject;

class MenuPrice extends FloatValueObject
{
    public function __construct(float $value)
    {
        parent::__construct($value);
    }
    public function update(float $value)
    {
        return new self($value);
    }
}
