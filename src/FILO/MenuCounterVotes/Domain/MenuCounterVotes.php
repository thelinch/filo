<?php

namespace Filo\MenuCounterVotes\Domain;

use Filo\Menus\Domain\MenuId;
use src\Shared\Domain\Aggregate\AggregateRoot;

class MenuCounterVotes extends AggregateRoot
{

    private MenuId $menuId;
    private MenuCounterVotesTotal $total;

    public function __construct(MenuId $menuId, MenuCounterVotesTotal $total)
    {
        $this->menuId = $menuId;
        $this->total = $total;
    }

    public function menuId(): MenuId
    {
        return $this->menuId;
    }
    public function total(): MenuCounterVotesTotal
    {
        return $this->total;
    }
    public function increment(): void
    {
        $this->total = $this->total->increment();
        $this->record(new MenuCounterVotesIncrementDomainEvent($this->menuId, $this->total()->value()));
    }
    public function decrement(): void
    {
        $this->total = $this->total->decrement();
        $this->record(new MenuCounterVotesDecrementDomainEvent($this->menuId, $this->total()->value()));
    }
}
