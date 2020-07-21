<?php

namespace Filo\Menus\Domain;

use src\Shared\Domain\ValueObject\StringValueObject;
use src\Shared\Domain\ValueObject\Uuid;

class MenuId extends Uuid
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
