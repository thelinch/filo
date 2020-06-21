<?php

namespace Filo\Partners\Application\Find;

use Filo\Partners\Domain\Partner;
use JsonSerializable;
use src\Shared\Domain\Bus\Query\Response;

class PartnerResponse implements Response, JsonSerializable
{
    private string $id;
    private string $name;
    private string $description;
    private int $dishes;
    private string $phone;
    private string $address;
    private  $category;
    private $workdays;
    private $city;
    private bool $isAvailableForAttend;
    private string $photo;
    public function __construct(Partner $partner)
    {
        $this->id = $partner->id()->value();
        $this->name = $partner->name()->value();
        $this->description = $partner->description()->value();
        $this->dishes = $partner->dishes()->value();
        $this->category = ["id" => $partner->category()->id(), "name" => $partner->category()->name()];
        $this->city = $partner->city();
        $this->address = $partner->address()->value();
        $this->phone = $partner->phone()->value();
        $this->isAvailableForAttend = $partner->isAvailableForAttention();
        $this->photo = $partner->photo()->value();
        $this->workdays = collect($partner->daysWork())->map(function ($dayWork) {
            return [
                "id" => $dayWork->id(),
                "startTime" => $dayWork->startTime(),
                "endTime" => $dayWork->endTime(),
                "day" => $dayWork->day()
            ];
        })->toArray();
    }
    public  function  id(): string
    {
        return $this->id;
    }
    public function jsonSerialize()
    {
        return
            [
                'id'   => $this->id,
                'name' => $this->name,
                "description" => $this->description,
                "dishes" => $this->dishes,
                "category" => $this->category,
                "address" => $this->address,
                "phone" => $this->phone,
                "city" => $this->city,
                "photo" => $this->photo,
                "workdays" => $this->workdays,
                "isAvailableForAttend" => $this->isAvailableForAttend
            ];
    }
}
