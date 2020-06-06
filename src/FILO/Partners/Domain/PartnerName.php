<?php

namespace Filo\Partners\Domain;

use src\Shared\Domain\ValueObject\StringValueObject;

class PartnerName extends StringValueObject
{

    public function __construct(string $value)
    {
        parent::__construct($value);
    }
    public function newName(string $newName)
    {
        return new self($newName);
    }
}
