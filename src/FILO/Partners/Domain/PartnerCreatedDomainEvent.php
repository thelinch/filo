<?php

declare(strict_types=1);

namespace Filo\Partners\Domain;

use src\Shared\Domain\Bus\Event\DomainEvent;

final class PartnerCreatedDomianEvent extends DomainEvent
{
    private string $name;
    private string $userId;
    public function __construct(string $id, string $name, string $userId, string $eventId = null, string $ocurredOn = null)
    {
        $this->name = $name;
        parent::__construct($id, $eventId, $ocurredOn);
    }
    public static function eventName(): string
    {
        return "Partner.created";
    }
    public function toPrimitives(): array
    {

        return [
            "name" => $this->name,

        ];
    }
    public function userId(): string
    {
        return $this->userId;
    }
    public function name(): string
    {
        return $this->name;
    }
}
