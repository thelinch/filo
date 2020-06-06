<?php

namespace App\Http\Controllers;

use Filo\Partners\Application\Delete\PartnerDelete;
use Filo\Partners\Domain\PartnerId;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class PartnerDeleteController extends ApiController
{



    private PartnerDelete $delete;

    public function exceptions(): array
    {
        return [];
    }
    public function  __construct()
    {
        $this->delete = App::make("partnerDelete");
    }

    public function __invoke(string $idPartner)
    {

        $this->delete->__invoke(new PartnerId($idPartner));
    }
}
