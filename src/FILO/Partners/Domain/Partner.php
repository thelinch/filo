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
    private PartnerAmountDelivery $amountDelivery;
    private PartnerState $state;
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
        PartnerAmountDelivery $amountDelivery,
        PartnerState $state,
        PartnerDayWork  ...$dayswork
    ) {
        $this->name = $name;
        $this->state = $state;
        $this->id = $id;
        $this->description = $description;
        $this->dishes = $dishes;
        $this->category = $category;
        $this->address = $address;
        $this->phone = $phone;
        $this->userId = $userId;
        $this->city = $city;
        $this->photo = $photo;
        $this->amountDelivery = $amountDelivery;
        $this->daysWork = $dayswork;
    }
    public function amountDelivery(): PartnerAmountDelivery
    {
        return $this->amountDelivery;
    }
    public function state(): PartnerState
    {
        return $this->state;
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
        PartnerPhoto $photo,
        PartnerAmountDelivery $amountDelivery,
        PartnerState $state,
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
            $photo,
            $amountDelivery,
            $state,
            ...$daysWork
        );
        $partner->record(new PartnerCreatedDomianEvent($id->value(), $name->value(), $userId->value()));
        return $partner;
    }
    public function rename(string $newName)
    {
        $this->name = $this->name->newName($newName);
    }
    public function toogleState()
    {
        $this->state = new PartnerState($this->state->value() == 1 ? 0 : 1);
    }
    public function updateAmountDelivery(float  $newAmount)
    {
        $this->amountDelivery = $this->amountDelivery->updateAmountDelivery($newAmount);
    }
    public function updatePhoto(string $newPhoto)
    {
        $this->photo = new PartnerPhoto($newPhoto);
    }
    public function addAndUpdateWorkDay(PartnerDayWork ...$daysWork)
    {
        /*  $collectDayWork =   collect($this->daysWork);
        $collectDaysWorkParameter = collect($daysWork);
        $collectDaysWorkAction = collect([]);
        $collectDayWork->each(function (PartnerDayWork $value) use ($collectDaysWorkParameter, $collectDaysWorkAction) {
            if ($collectDaysWorkParameter->contains(fn (PartnerDayWork $dayWorkParameter) => $dayWorkParameter->id() == $value->id())) {
            
            } else {
                $collectDaysWorkAction->push($value);
            }
        }); */

        $this->daysWork = collect($daysWork)->toArray();
    }

    public function deleteWorkDay(PartnerDayWork $dayWork)
    {
        $collectDayWork =    collect($this->daysWork);
        if ($collectDayWork->contains(fn (PartnerDayWork $value, $key) => $value->id() == $dayWork->id())) {
            $collectDayWork = $collectDayWork->filter(fn (PartnerDayWork $value, $key) => $value->id() != $dayWork->id());
        }
        $this->daysWork = $collectDayWork->toArray();
    }

    public function updatePhone(string $newPhone)
    {
        $this->phone = new PartnerPhone($newPhone);
    }
    public function updateDescription(string $newDescription)
    {
        $this->description = $this->description->updateDescription($newDescription);
    }
    public function updayeCity(int $id, string $name)
    {
        $this->city = new PartnerCity($id, $name);
    }
    public function updateCategory(int $id, string $name)
    {
        $this->category = new PartnerCategory($id, $name);
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
