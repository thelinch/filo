<?php

namespace App\Http\Controllers;

use Filo\Partners\Application\All\PartnerList;
use Filo\Partners\Application\All\PartnerListResponse;
use Illuminate\Support\Facades\App;
use src\Shared\Domain\Pagination\NextPage;
use src\Shared\Domain\Pagination\NumberPerPage;
use src\Shared\Infraestructure\Eloquent\ApiController;

class PartnerListController extends ApiController
{
    private PartnerList $partnerList;

    public function exceptions(): array
    {
        return [];
    }
    public function __construct()
    {
        $this->partnerList = App::make("partnerList");
    }

    public function __invoke()
    {
        $partnerListResponse = new PartnerListResponse($this->partnerList->__invoke(new NextPage(2), new NumberPerPage(6)));
        return $partnerListResponse;
    }
}
