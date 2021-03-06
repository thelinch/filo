<?php

namespace Filo\Menus\Application\All;

use Filo\Menus\Domain\MenuRepositoryI;
use Filo\Menus\Domain\Paginate\MenuPaginate;
use Filo\Menus\Infraestructure\EloquentMenuRepository;
use Filo\Partners\Domain\PartnerId;
use Filo\Partners\Domain\Service\PartnerFinder;
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
        $this->partnerFinder = App::make(PartnerFinder::class);
    }


    public function __invoke(NextPage $nextPartnerPage, NumberPerPage $numberPartnerPerPage, PartnerId  $partnerId): MenuPaginate
    {
        $partner = $this->partnerFinder->__invoke($partnerId);
        return $this->repository->all($nextPartnerPage, $numberPartnerPerPage, $partner->id());
    }
}
