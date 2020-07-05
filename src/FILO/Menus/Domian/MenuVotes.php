<?php

namespace Filo\Menus\Domain;

use src\Shared\Domain\ValueObject\IntValueObject;

class MenuVotes extends IntValueObject
{
    public function __construct(int $value)
    {
        parent::__construct($value);
    }

    public function increment(): self
    {
        $increment = $this->value + 1;
        return new self($increment);
    }
}
