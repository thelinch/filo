<?php

namespace Filo\Partners\Application\Update;

use Filo\Partners\Application\Find\PartnerFinder;
use Filo\Partners\Domain\PartnerAddress;
use Filo\Partners\Domain\PartnerAmountDelivery;
use Filo\Partners\Domain\PartnerCategory;
use Filo\Partners\Domain\PartnerCity;
use Filo\Partners\Domain\PartnerDescription;
use Filo\Partners\Domain\PartnerId;
use Filo\Partners\Domain\PartnerName;
use Filo\Partners\Domain\PartnerPhone;
use Filo\Partners\Domain\PartnerPhoto;
use Filo\Partners\Domain\PartnerRepositoryI;
use Illuminate\Support\Facades\App;

class PartnerUpdate
{
    private PartnerRepositoryI $repository;
    private PartnerFinder $partnerFinder;
    public function __construct(PartnerRepositoryI $repository)
    {
        $this->repository = $repository;
        $this->partnerFinder = App::make("partnerFinder");
    }
    public function __invoke(PartnerId $id, PartnerName $name, PartnerDescription $description, PartnerAddress $address, PartnerAmountDelivery $amountDelivery, PartnerCategory $newCategory, PartnerCity $newCity, PartnerPhoto $newPhoto, PartnerPhone $newPartnerPhone)
    {
        $partner = $this->partnerFinder->__invoke($id);
        $partner->updateDescription($description->value());
        $partner->updateDirection($address->value());
        $partner->rename($name->value());
        $partner->updateAmountDelivery($amountDelivery->value());
        $partner->updateCategory($newCategory->id(), $newCategory->name());
        $partner->updayeCity($newCity->id(), $newCity->name());
        $partner->updatePhone($newPartnerPhone->value());
        $partner->updatePhoto($newPhoto->value());
        $this->repository->update($partner);
    }
}
