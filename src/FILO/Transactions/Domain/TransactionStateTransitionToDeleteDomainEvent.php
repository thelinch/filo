<?php

namespace Filo\Transactions\Domain;

use src\Shared\Domain\Bus\Event\DomainEvent;

class TransactionStateTransitionToDeleteDomainEvent extends DomainEvent
{
    private string $transitionId;
    public function __construct(
        string $transitionId,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($transitionId, $eventId, $occurredOn);
        $this->transitionId = $transitionId;
    }
    public static function eventName(): string
    {
        return 'transactionstate.delete';
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self($aggregateId, $eventId, $occurredOn);
    }

    public function toPrimitives(): array
    {
        return [
            'id'     => $this->transitionId,
        ];
    }

    public function transitionId(): string
    {
        return $this->transitionId;
    }
}
