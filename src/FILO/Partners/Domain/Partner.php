<?php

namespace Filo\Partners\Domain;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
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
    private PartnerCity $city;
    private PartnerPhoto $photo;
    public function __construct(
        PartnerId $id,
        PartnerDescription $description,
        PartnerName $name,
        PartnerDishes $dishes,
        PartnerCategory $category,
        PartnerAddress $address,
        PartnerPhone $phone,
        UserId $userId,
        PartnerCity $city,
        PartnerPhoto $photo,
        PartnerDayWork  ...$dayswork
    ) {
        $this->name = $name;
        $this->id = $id;
        $this->description = $description;
        $this->dishes = $dishes;
        $this->category = $category;
        $this->address = $address;
        $this->phone = $phone;
        $this->userId = $userId;
        $this->city = $city;
        $this->photo = $photo;
        $this->daysWork = $dayswork;
    }

    public function isAvailableForAttention(): bool
    {
        $isAvailableForAttention = false;
        $today = Carbon::now()->setTimezone("America/Lima")->locale("es_ES");
        $todayInDay = ucfirst($today->dayName);
        //Buscamos  de los dias que estan registrados si existe el dia de hoy
        $dayWork = collect($this->daysWork)->first(function (PartnerDayWork $dayWork) use ($todayInDay) {
            return  $dayWork->day() == $todayInDay;
        });
        if ($dayWork) {
            $startTime = Carbon::createFromTimeString($dayWork->startTime(), "America/Lima");
            $endTime = Carbon::createFromTimeString($dayWork->endTime(), "America/Lima");
            $isAvailableForAttention = $today->isBetween($startTime, $endTime);
        }
        return $isAvailableForAttention;
    }
    public function photo(): PartnerPhoto
    {
        return $this->photo;
    }
    public function city()
    {
        return $this->city;
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
        PartnerCity $city,
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
            $city,
            ...$daysWork
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
