<?php

namespace Filo\Menus\Application\All;

use Filo\Menus\Domain\MenuRepositoryI;
use Filo\Menus\Domain\Paginate\MenuPaginate;
use Filo\Menus\Infraestructure\EloquentMenuRepository;
use Filo\Partners\Domain\PartnerId;
use src\Shared\Domain\Pagination\NextPage;
use src\Shared\Domain\Pagination\NumberPerPage;

class MenuListFindPartner
{
    private MenuRepositoryI $repository;

    public function __construct(MenuRepositoryI $repository)
    {
        $this->repository = $repository;
    }


    public function __invoke(NextPage $nextPartnerPage, NumberPerPage $numberPartnerPerPage, PartnerId  $partnerId): MenuPaginate
    {
        return $this->repository->all($nextPartnerPage, $numberPartnerPerPage, $partnerId);
    }
}
