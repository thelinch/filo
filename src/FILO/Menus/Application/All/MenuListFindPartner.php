<?php

namespace Filo\Menus\Application\All;

use Filo\Menus\Domain\MenuRepositoryI;
use Filo\Menus\Domain\Paginate\MenuPaginate;
use Filo\Partners\Application\Find\PartnerFinder;
use Filo\Partners\Domain\PartnerId;
use Illuminate\Support\Facades\App;
use src\Shared\Domain\Pagination\NextPage;
use src\Shared\Domain\Pagination\NumberPerPage;

class MenuListFindPartner
{
    private MenuRepositoryI $repository;
    private PartnerFinder $partnerFinder;
    public function __construct(MenuRepositoryI $repository)
    {
        $this->repository = $repository;
        $this->partnerFinder = App::make("partnerFinder");
    }


    public function __invoke(NextPage $nextPartnerPage, NumberPerPage $numberPartnerPerPage, PartnerId  $partnerId): MenuPaginate
    {

        $this->partnerFinder->__invoke($partnerId);
        return $this->repository->all($nextPartnerPage, $numberPartnerPerPage, $partnerId);
    }
}
