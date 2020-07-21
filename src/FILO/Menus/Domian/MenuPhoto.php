<?php

namespace Filo\Menus\Domain;

use src\Shared\Domain\ValueObject\StringValueObject;

class MenuPhoto extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
    public function delete(): self
    {
        return new self("");
    }
}
