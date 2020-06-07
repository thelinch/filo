<?php

namespace Filo\PartnerCounterDishes\Application\Increment;

use Filo\Menus\Domain\MenuCreateDomainEvent;
use Filo\PartnerCounterDishes\Domain\PartnerCounterDishes;
use Filo\PartnerCounterDishes\Domain\PartnerCounterDishesRepository;
use Filo\PartnerCounterDishes\Domain\PartnerCounterDishesTotal;
use Filo\Partners\Application\Find\PartnerFinder;
use Filo\Partners\Domain\PartnerId;
use Illuminate\Support\Facades\App;
use Prooph\Common\Event\ActionEventListenerAggregate;

class PartnerCounterDishesIncrement implements ActionEventListenerAggregate
{
    private PartnerFinder $partnerFinder;

    private PartnerCounterDishesRepository $repository;
    public function __construct(PartnerCounterDishesRepository $repository)
    {
        $this->partnerFinder = App::make("partnerFinder");
        $this->repository = $repository;
    }

    public function __invoke(MenuCreateDomainEvent $event)
    {
        $partnerId = new PartnerId($event->partnerId);
        $partner = $this->partnerFinder->__invoke($partnerId);
        $counter = new PartnerCounterDishes($partnerId, new PartnerCounterDishesTotal($partner->dishes()->value()));
        $counter->increment();
        $this->repository->updateCounterDishes($counter);
    }
}
