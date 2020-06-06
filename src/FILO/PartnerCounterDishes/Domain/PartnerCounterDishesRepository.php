<?php

namespace Filo\PartnerCounterDishes\Domain;

interface PartnerCounterDishesRepository
{
    public function updateCounterDishes(PartnerCounterDishes $partnerCounterDishes);
}
