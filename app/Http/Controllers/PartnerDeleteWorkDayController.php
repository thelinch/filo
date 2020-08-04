<?php

namespace App\Http\Controllers;

use Filo\Partners\Application\DeleteWorkDay\DeletorWorkDay;
use Filo\Partners\Domain\PartnerDayWork;
use Filo\Partners\Domain\PartnerId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class PartnerDeleteWorkDayController extends ApiController
{
    private DeletorWorkDay $deletorWorkDay;

    public function exceptions(): array
    {
        return [];
    }
    public function __construct()
    {
        $this->deletorWorkDay = App::make(DeletorWorkDay::class);
    }

    public function __invoke(string $partnerId, Request $request)
    {
        $dayWorkParameter = $request->only(["id", "day", "startime", "endtime"]);
        $this->deletorWorkDay->__invoke(new PartnerDayWork($dayWorkParameter["startime"], $dayWorkParameter["endtime"], $dayWorkParameter["day"]["name"], $dayWorkParameter["day"]["id"], $dayWorkParameter["id"]), new PartnerId($partnerId));
    }
}
