<?php

namespace Filo\PartnerCounterDishes\Domain;

use Filo\Partners\Domain\PartnerId;
use src\Shared\Domain\Aggregate\AggregateRoot;

class PartnerCounterDishes extends AggregateRoot
{
    private PartnerId $partnerId;
    private PartnerCounterDishesTotal $total;

    public function __construct(PartnerId $partnerId, PartnerCounterDishesTotal $total)
    {
        $this->partnerId = $partnerId;
        $this->total = $total;
    }
    public static function initialize(PartnerId $partnerId): self
    {
        return new self($partnerId, PartnerCounterDishesTotal::initialize());
    }
    public function partnerId(): PartnerId
    {
        return $this->partnerId;
    }
    public function total(): PartnerCounterDishesTotal
    {
        return $this->total;
    }
    //Incrementa el contador +1 de un partner se agregar el evento
    public function increment(): void
    {
        $this->total = $this->total->increment();
        //record domain evento counter incremement
        $this->record(new PartnerCounterDishesIncrementDomainEvent($this->partnerId->value(), $this->total->value()));
    }
    public function decrement(): void
    {
        $this->total = $this->total->decrement();
        $this->record(new PartnerCounterDishesDecrementDomainEvent($this->partnerId->value(), $this->total->value()));
    }
}
