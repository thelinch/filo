<?php

namespace App\Http\Controllers;

use Filo\Partners\Application\Create\PartnerCreator as CreatePartnerCreator;
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
use Filo\Partners\Domain\PartnerState;
use Filo\Users\Domain\UserId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class PartnerPostController extends ApiController
{

    private CreatePartnerCreator $parnertCreator;
    public function __construct()
    {
        $this->parnertCreator = App::make(CreatePartnerCreator::class);
        /*  $this->middleware("auth:api"); */
    }
    public function exceptions(): array
    {
        return [];
    }

    public function __invoke(Request $request)
    {
        $partnerParameter = $request->only(["id", "address", "name", "amountdelivery", "category", "workdays", "phone", "photo", "description", "user", "city"]);
        $daysWorks = collect($partnerParameter["workdays"])->map(function ($daywork) {
            return new PartnerDayWork($daywork["startime"], $daywork["endtime"], $daywork["day"]["name"], $daywork["day"]["id"], $daywork["id"]);
        });
        $this->parnertCreator->__invoke(
            new PartnerId($partnerParameter["id"]),
            new PartnerCategory($partnerParameter["category"]["id"], "defecto"),
            new PartnerAddress($partnerParameter["address"]),
            new UserId("wdwdwd1dwdwd-wdwd12"),
            new PartnerPhone($partnerParameter["phone"]),
            new PartnerName($partnerParameter["name"]),
            new PartnerDescription($partnerParameter["description"]),
            new PartnerDishes(0),
            new PartnerCity($partnerParameter["city"]["id"], "defecto"),
            new PartnerPhoto($partnerParameter["photo"]),
            new PartnerAmountDelivery($partnerParameter["amountdelivery"]),
            new PartnerState(1),
            $daysWorks->toArray()
        );
    }
}
