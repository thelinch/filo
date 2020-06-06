<?php

namespace Filo\Menus\Domain;

use src\Shared\Domain\Bus\Event\DomainEvent;

class MenuCreateDomainEvent extends DomainEvent
{
    private string $name;
    public function __construct(string $id, string $name, string $eventId = null, string $ocurredOn = null)
    {
        $this->name = $name;
        parent::__construct($id, $eventId, $ocurredOn);
    }
    public static function eventName(): string
    {
        return "Menu.created";
    }
    public function toPrimitives(): array
    {

        return [
            "name" => $this->name,

        ];
    }
    public function name(): string
    {
        return $this->name;
    }
}
