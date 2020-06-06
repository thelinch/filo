<?php

namespace Filo\PartnerCounterDishes\Application\Increment;

use Filo\PartnerCounterDishes\Domain\PartnerCounterDishes;
use Filo\PartnerCounterDishes\Domain\PartnerCounterDishesRepository;
use Filo\PartnerCounterDishes\Domain\PartnerCounterDishesTotal;
use Filo\Partners\Application\Find\PartnerFinder;
use Filo\Partners\Domain\PartnerId;
use Illuminate\Support\Facades\App;

class PartnerCounterDishesIncrement
{
    private PartnerFinder $partnerFinder;

    private PartnerCounterDishesRepository $repository;
    public function __construct(PartnerCounterDishesRepository $repository)
    {
        $this->partnerFinder = App::make("partnerFinder");
        $this->repository = $repository;
    }

    public function __invoke(PartnerId $partnerId)
    {
        $partner = $this->partnerFinder->__invoke($partnerId);
        $counter = new PartnerCounterDishes($partnerId, new PartnerCounterDishesTotal($partner->dishes()->value()));
        $counter->increment();
        $this->repository->updateCounterDishes($counter);
    }
}
