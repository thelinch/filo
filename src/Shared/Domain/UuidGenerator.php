<?php

namespace src\Shared\Domain;

interface UuidGenerator
{
    public function generate(): string;
}
