<?php

namespace Filo\MenuCounterVotes\Domain;

use src\Shared\Domain\ValueObject\IntValueObject;

class MenuCounterVotesTotal extends IntValueObject
{
    public function __construct(int $value)
    {
        parent::__construct($value);
    }
    public function initialize(): self
    {
        return new self(0);
    }
    public function increment(): self
    {
        return new self($this->value + 1);
    }
    public function decrement(): self
    {
        return new self($this->value - 1);
    }
}
