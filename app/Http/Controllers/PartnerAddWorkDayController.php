<?php

namespace App\Http\Controllers;

use Filo\Partners\Application\AddWorkDay\AddWorkDay;
use Filo\Partners\Domain\PartnerDayWork;
use Filo\Partners\Domain\PartnerId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class PartnerAddWorkDayController extends ApiController
{
    private AddWorkDay $addWorkDay;

    public function exceptions(): array
    {
        return [];
    }
    public function __construct()
    {
        $this->addWorkDay = App::make(addWorkDay::class);
    }

    public function __invoke(string $partnerId, Request $request)
    {
        $dayWorkParameter = $request->all();
        $partnerDayWok = collect($dayWorkParameter)->map(fn ($value) => new PartnerDayWork($value["startime"], $value["endtime"], $value["day"]["name"], $value["day"]["id"], $value["id"]));
        $this->addWorkDay->__invoke(new PartnerId($partnerId), ...$partnerDayWok->toArray());
    }
}
