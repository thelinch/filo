<?php

namespace Filo\PartnerCounterDishes\Infraestructure;

use Filo\PartnerCounterDishes\Domain\PartnerCounterDishes;
use Filo\PartnerCounterDishes\Domain\PartnerCounterDishesRepository;
use Filo\Partners\Infraestructure\PartnerModel;

class EloquentCounterDishesRepository implements PartnerCounterDishesRepository
{
    public function updateCounterDishes(PartnerCounterDishes $partnerCounterDishes)
    {
        $partnerModel = PartnerModel::find($partnerCounterDishes->partnerId()->value());
        $partnerModel->counterdishes = $partnerCounterDishes->total()->value();
        $partnerModel->save();
    }
}
