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
    private  $category;
    private $workdays;
    private $city;
    public function __construct(Partner $partner)
    {
        $this->id = $partner->id()->value();
        $this->name = $partner->name()->value();
        $this->description = $partner->description()->value();
        $this->dishes = $partner->dishes()->value();
        $this->category = ["id" => $partner->category()->id(), "name" => $partner->category()->name()];
        $this->city = $partner->city();
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
                "city" => $this->city,
                "workdays" => $this->workdays
            ];
    }
}
