<?php

namespace src\Shared\Domain\ValueObject;


abstract class FloatValueObject
{
    protected float $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }
    public function value(): float
    {
        return $this->value;
    }
    public function __toString()
    {
        return (string) $this->value();
    }
}
