<?php

namespace Filo\Partners\Domain;

use src\Shared\Domain\Aggregate\AggregateRoot;
use Filo\Users\Domain\UserId;

final class Partner extends AggregateRoot
{
    private PartnerId $id;
    private PartnerDescription $description;
    private PartnerName $name;
    private PartnerDishes $dishes;
    private PartnerCategory $category;
    private PartnerAddress $address;
    private PartnerPhone $phone;
    private UserId $userId;
    private array $daysWork;
    public function __construct(
        PartnerId $id,
        PartnerDescription $description,
        PartnerName $name,
        PartnerDishes $dishes,
        PartnerCategory $category,
        PartnerAddress $address,
        PartnerPhone $phone,
        UserId $userId,
        array $dayswork
    ) {
        $this->name = $name;
        $this->id = $id;
        $this->description = $description;
        $this->dishes = $dishes;
        $this->category = $category;
        $this->address = $address;
        $this->phone = $phone;
        $this->userId = $userId;
        $this->daysWork = $dayswork;
    }
    public static function create(
        PartnerId $id,
        PartnerDescription $description,
        PartnerName $name,
        PartnerDishes $dishes,
        PartnerCategory $category,
        PartnerAddress $address,
        PartnerPhone $phone,
        UserId $userId,
        array $daysWork
    ): self {
        $partner = new self(
            $id,
            $description,
            $name,
            $dishes,
            $category,
            $address,
            $phone,
            $userId,
            $daysWork
        );
        $partner->record(new PartnerCreatedDomianEvent($id->value(), $name->value()));
        return $partner;
    }
    public function rename(string $newName)
    {
        $this->name = $this->name->newName($newName);
    }
    public function updateDescription(string $newDescription)
    {
        $this->description = $this->description->updateDescription($newDescription);
    }
    public function updateDirection(string $newDirection)
    {
        $this->address = $this->address->updateAddress($newDirection);
    }
    public function category(): PartnerCategory
    {
        return $this->category;
    }
    public function phone(): PartnerPhone
    {
        return $this->phone;
    }
    public function address(): PartnerAddress
    {
        return $this->address;
    }
    public function daysWork(): array
    {
        return $this->daysWork;
    }
    public function dishes(): PartnerDishes
    {
        return $this->dishes;
    }
    public function name(): PartnerName
    {
        return $this->name;
    }
    public function id(): PartnerId
    {
        return $this->id;
    }
    public function userId(): UserId
    {
        return $this->userId;
    }
    public function description(): PartnerDescription
    {

        return $this->description;
    }
}
