<?php

namespace Filo\Transactions\Domain;

use src\Shared\Domain\Bus\Event\DomainEvent;

class TransactionCreatedDomainEvent extends  DomainEvent
{

    private float $total;
    private string $partnerId;
    private array $items;
    public function __construct(
        string $id,
        float $total,
        string $partnerId,
        array $items,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);

        $this->total = $total;
        $this->partnerId = $partnerId;
        $this->items = $items;
    }
    public static function eventName(): string
    {
        return 'transaction.created';
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self($aggregateId, $body['total'], $body['partnerId'], $body["items"], $eventId, $occurredOn);
    }

    public function toPrimitives(): array
    {
        return [
            'id'     => $this->id,
            'partnerId' => $this->partnerId,
            "total" => $this->total,
            "items" => $this->items
        ];
    }

    public function total(): float
    {
        return $this->total;
    }

    public function partnerId(): string
    {
        return $this->partnerId;
    }
    public function items(): array
    {
        return $this->items;
    }
}
