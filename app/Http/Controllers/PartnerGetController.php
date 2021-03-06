<?php

namespace App\Http\Controllers;

use Filo\Partners\Application\Find\PartnerResponse;
use Filo\Partners\Domain\PartnerId;
use Filo\Partners\Domain\PartnerNotExist;
use Filo\Partners\Domain\Service\PartnerFinder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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
        $this->partnerFinder = App::make(PartnerFinder::class);
    }


    public function __invoke()
    {
        $userAuth = Auth::guard("api")->user();
        if (!$userAuth->hasRole(["administrator"])) {
            return response([
                "message" => "user not role"
            ], 500);
        }
        $partnerId = $userAuth->partner->id;
        $partnerId = new PartnerId($partnerId);
        $partnerResponse = new PartnerResponse($this->partnerFinder->__invoke($partnerId, [1, 0]));
        return $partnerResponse;
    }
}
