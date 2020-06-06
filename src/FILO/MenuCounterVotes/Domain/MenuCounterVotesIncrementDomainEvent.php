<?php

namespace Filo\MenuCounterVotes\Domain;

use src\Shared\Domain\Bus\Event\DomainEvent;

class MenuCounterVotesIncrementDomainEvent extends DomainEvent
{
    private int $total;
    public function __construct(string $aggregateId, string $eventId = null, string $occurredOn = null)
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }
    public function  total(): int
    {
        return $this->total;
    }
    public static function eventName(): string
    {
        return 'votes_counter.increment';
    }

    public function toPrimitives(): array
    {
        return [
            'total' => $this->total,
        ];
    }
}
