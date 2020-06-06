<?php

namespace App\Http\Controllers;

use Filo\Partners\Application\Find\PartnerFinder;
use Filo\Partners\Application\Find\PartnerResponse;
use Filo\Partners\Domain\PartnerId;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class PartnerGetController extends ApiController
{

    private PartnerFinder $partnerFinder;

    public function exceptions(): array
    {
        return [];
    }
    public function __construct()
    {
        $this->partnerFinder = App::make("partnerFinder");
    }

    public function __invoke(string $idPartner)
    {
        $partnerId = new PartnerId($idPartner);
        $partnerResponse = new PartnerResponse($this->partnerFinder->__invoke($partnerId));
        return $partnerResponse;
    }
}
