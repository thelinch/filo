<?php

namespace Filo\PartnerCounterDishes\Domain;

use src\Shared\Domain\ValueObject\IntValueObject;

class PartnerCounterDishesTotal extends IntValueObject
{

    public function __construct(int $value)
    {
        parent::__construct($value);
    }
    public static function initialize(): self
    {
        return new self(0);
    }
    public function increment(): self
    {
        return new self($this->value() + 1);
    }
    public function decrement(): self
    {
        return new self($this->value() - 1);
    }
}
