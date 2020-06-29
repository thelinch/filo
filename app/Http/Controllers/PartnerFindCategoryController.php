<?php

namespace App\Http\Controllers;

use Filo\Partners\Application\All\PartnerListResponse;
use Filo\Partners\Application\Find\PartnerFinder;
use Filo\Partners\Application\Find\PartnerResponse;
use Filo\Partners\Application\FindCategory\PartnerListFindCategory;
use Filo\Partners\Domain\PartnerId;
use Filo\Partners\Domain\PartnerNotExist;
use Illuminate\Support\Facades\App;
use src\Shared\Domain\Pagination\NextPage;
use src\Shared\Domain\Pagination\NumberPerPage;
use src\Shared\Infraestructure\Eloquent\ApiController;
use Symfony\Component\HttpFoundation\Response;

class PartnerFindCategoryController extends ApiController
{

    private PartnerListFindCategory $partnerFinder;

    public function exceptions(): array
    {
        return [
            PartnerNotExist::class => Response::HTTP_NOT_FOUND
        ];
    }
    public function __construct()
    {
        $this->partnerFinder = App::make(PartnerListFindCategory::class);
    }

    public function __invoke(string $categoryName)
    {
        $partnerListResponse = new PartnerListResponse($this->partnerFinder->__invoke(new NextPage(3), new NumberPerPage(5), $categoryName));
        return $partnerListResponse;
    }
}
