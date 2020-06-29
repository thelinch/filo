<?php

namespace App\Http\Controllers;

use Filo\Partners\Application\Find\PartnerFinder;
use Filo\Partners\Application\Find\PartnerResponse;
use Filo\Partners\Domain\PartnerId;
use Filo\Partners\Domain\PartnerNotExist;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;
use Symfony\Component\HttpFoundation\Response;

class PartnerGetController extends ApiController
{

    private PartnerFinder $partnerFinder;

    public function exceptions(): array
    {
        return [
            PartnerNotExist::class => Response::HTTP_NOT_FOUND
        ];
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
