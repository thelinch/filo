<?php

namespace Filo\Menus\Domain;

use src\Shared\Domain\ValueObject\StringValueObject;

class MenuDescription extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
