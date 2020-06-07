<?php

namespace Filo\Menus\Domain;

use src\Shared\Domain\Bus\Event\DomainEvent;

class MenuCreateDomainEvent extends DomainEvent
{
    private string $name;
    private string $partnerId;

    public function __construct(string $id, string $name, string $partnerId, string $eventId = null, string $ocurredOn = null)
    {
        $this->name = $name;
        $this->partnerId = $partnerId;
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
            "partnerId" => $this->partnerId

        ];
    }
    public function name(): string
    {
        return $this->name;
    }
}
