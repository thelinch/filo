<?php

namespace Filo\PartnerCounterDishes\Domain;

use src\Shared\Domain\Bus\Event\DomainEvent;

class PartnerCounterDishesDecrementDomainEvent extends DomainEvent
{
    private int $total;

    public function __construct(string $aggregateId, int $total, string $eventId = null, string $occurredOn = null)
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);

        $this->total = $total;
    }

    public static function eventName(): string
    {
        return 'dishes_counter.decrement';
    }

    public function toPrimitives(): array
    {
        return [
            'total' => $this->total,
        ];
    }
}
