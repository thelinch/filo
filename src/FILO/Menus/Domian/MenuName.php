<?php

namespace Filo\Menus\Domain;

use src\Shared\Domain\ValueObject\StringValueObject;

class MenuName extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
    public function update(string $newName): self
    {
        return new self($newName);
    }
}
