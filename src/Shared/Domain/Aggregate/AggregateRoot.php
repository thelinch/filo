<?php

namespace src\Shared\Domain\Aggregate;

use src\Shared\Domain\Bus\Event\DomainEvent;

abstract class AggregateRoot
{
    private array $domainEvents = [];

    final public function pullDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];
        return $domainEvents;
    }
    final protected function record(DomainEvent $domainEvents): void
    {
        $this->domainEvents[] = $domainEvents;
    }
}
