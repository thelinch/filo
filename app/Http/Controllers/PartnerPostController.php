<?php

namespace App\Http\Controllers;

use Filo\Partners\Application\Create\PartnerCreator as CreatePartnerCreator;
use Filo\Partners\Domain\PartnerAddress;
use Filo\Partners\Domain\PartnerCategory;
use Filo\Partners\Domain\PartnerDayWork;
use Filo\Partners\Domain\PartnerDescription;
use Filo\Partners\Domain\PartnerDishes;
use Filo\Partners\Domain\PartnerId;
use Filo\Partners\Domain\PartnerName;
use Filo\Partners\Domain\PartnerPhone;
use Filo\Users\Domain\UserId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class PartnerPostController extends ApiController
{

    private CreatePartnerCreator $parnertCreator;
    public function __construct()
    {
        $this->parnertCreator = App::make("partnerCreator");
    }
    public function exceptions(): array
    {
        return [];
    }

    public function __invoke(Request $request)
    {
        $partnerParameter = $request->only(["id", "address", "name", "category", "daysworks", "phone", "description", "user"]);
        $daysWorks = collect($partnerParameter["daysworks"])->map(function ($daywork) {
            return new PartnerDayWork($daywork["startime"], $daywork["endtime"], $daywork["day"]["name"], $daywork["day"]["id"], $daywork["id"]);
        });
        $this->parnertCreator->__invoke(
            new PartnerId($partnerParameter["id"]),
            new PartnerCategory($partnerParameter["category"]["id"], $partnerParameter["category"]["name"]),
            new PartnerAddress($partnerParameter["address"]),
            new UserId($partnerParameter["user"]["id"]),
            new PartnerPhone($partnerParameter["phone"]),
            new PartnerName($partnerParameter["name"]),
            new PartnerDescription($partnerParameter["description"]),
            new PartnerDishes(0),
            $daysWorks->toArray()
        );
    }
}
