<?php

namespace Filo\Transactions\Domain;

use src\Shared\Domain\Bus\Event\DomainEvent;

class TransactionStateTransitionToOnMyWayDomainEvent extends DomainEvent
{
    private string $transitionId;
    private string $code;
    public function __construct(
        string $transitionId,
        string $code,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($transitionId, $eventId, $occurredOn);
        $this->code = $code;
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
    public function code(): string
    {
        return $this->code;
    }
    public function transitionId(): string
    {
        return $this->transitionId;
    }
}
