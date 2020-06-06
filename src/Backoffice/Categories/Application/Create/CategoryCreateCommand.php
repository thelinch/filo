<?php

namespace backoffice\Categories\Application\Create;

use src\Shared\Domain\Bus\Command\Command;

//final class CreatePartnerCommand implements \Rosamarsky\CommandBus\Command
final class CreateCategoryCommand implements Command
{
    private string $id;
    private string $name;
    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
    public function id(): string
    {
        return $this->id;
    }
    public function name(): string
    {
        return $this->name;
    }
}
