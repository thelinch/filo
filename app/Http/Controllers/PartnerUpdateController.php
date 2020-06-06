<?php

namespace App\Http\Controllers;

use Filo\Partners\Application\Update\PartnerUpdate;
use Filo\Partners\Domain\PartnerAddress;
use Filo\Partners\Domain\PartnerDescription;
use Filo\Partners\Domain\PartnerId;
use Filo\Partners\Domain\PartnerName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class PartnerUpdateController extends ApiController
{

    private PartnerUpdate $partnerUpdate;
    public function exceptions(): array
    {
        return [];
    }
    public function __construct()
    {
        $this->partnerUpdate = App::make("partnerUpdate");
    }

    public function __invoke(Request $request)
    {
        $partnerParameter = $request->only(["id", "name", "description", "address"]);
        $this->partnerUpdate->__invoke(
            new PartnerId($partnerParameter["id"]),
            new PartnerName($partnerParameter["name"]),
            new PartnerDescription($partnerParameter["description"]),
            new PartnerAddress($partnerParameter["address"])
        );
    }
}
