<?php

namespace Filo\PartnerCounterDishes\Application\Decrement;

use Filo\Menus\Domain\MenuDeleteDomainEvent;
use Filo\PartnerCounterDishes\Domain\PartnerCounterDishes;
use Filo\PartnerCounterDishes\Domain\PartnerCounterDishesRepository;
use Filo\PartnerCounterDishes\Domain\PartnerCounterDishesTotal;
use Filo\Partners\Application\Find\PartnerFinder;
use Filo\Partners\Domain\PartnerId;
use Illuminate\Support\Facades\App;

class PartnerCounterDishesDecrement
{
    private PartnerFinder $partnerFinder;

    private PartnerCounterDishesRepository $repository;
    public function __construct(PartnerCounterDishesRepository $repository)
    {
        $this->partnerFinder = App::make("partnerFinder");
        $this->repository = $repository;
    }

    public function handle(MenuDeleteDomainEvent $event): void
    {
        $partnerId = new PartnerId($event->partnerId());
        $partner = $this->partnerFinder->__invoke($partnerId);
        if ($partner->dishes()->value() > 0) {
            $counter = new PartnerCounterDishes($partnerId, new PartnerCounterDishesTotal($partner->dishes()->value()));
            $counter->decrement();
            $this->repository->updateCounterDishes($counter);
        }
    }
}
