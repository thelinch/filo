<?php

namespace  Filo\Partners\Application\Create;

use Filo\Partners\Domain\Partner;
use Filo\Partners\Domain\PartnerAddress;
use Filo\Partners\Domain\PartnerAmountDelivery;
use Filo\Partners\Domain\PartnerCategory;
use Filo\Partners\Domain\PartnerCity;
use Filo\Partners\Domain\PartnerDayWork;
use Filo\Partners\Domain\PartnerDescription;
use Filo\Partners\Domain\PartnerDishes;
use Filo\Partners\Domain\PartnerId;
use Filo\Partners\Domain\PartnerName;
use Filo\Partners\Domain\PartnerPhone;
use Filo\Partners\Domain\PartnerPhoto;
use Filo\Partners\Domain\PartnerRepositoryI;
use Filo\Partners\Domain\PartnerState;
use Filo\Users\Domain\UserId;
use src\Shared\Domain\Bus\Event\EventBus;
use src\Shared\Domain\UuidGenerator;

final class PartnerCreator
{
    private PartnerRepositoryI $repository;
    private UuidGenerator $uuid;
    private EventBus $bus;
    public function __construct(PartnerRepositoryI $repository, EventBus $bus)
    {
        $this->repository = $repository;
        $this->bus = $bus;
    }
    public function __invoke(
        PartnerId $partnerId,
        PartnerCategory $category,
        PartnerAddress $address,
        UserId $userId,
        PartnerPhone $phone,
        PartnerName $name,
        PartnerDescription $description,
        PartnerDishes $dishes,
        PartnerCity $city,
        PartnerPhoto $photo,
        PartnerAmountDelivery $amountDelivery,
        PartnerState $state,
        array $daysWork
    ) {
        $partner = Partner::create($partnerId, $description, $name, $dishes, $category, $address, $phone, $userId, $city, $photo, $amountDelivery, $state, $daysWork);
        $this->repository->create($partner);
        /* $this->bus->publish(...$partner->pullDomainEvents()); */
    }
}
