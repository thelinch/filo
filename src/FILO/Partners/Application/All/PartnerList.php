<?php

namespace  Filo\Partners\Application\All;

use Filo\Partners\Domain\Pagination\PaginationPartner;
use Filo\Partners\Domain\PartnerRepositoryI;
use src\Shared\Domain\Pagination\NextPage;
use src\Shared\Domain\Pagination\NumberPerPage;
use src\Shared\Domain\Pagination\PreviusPage;
use src\Shared\Domain\Pagination\Total;

class PartnerList
{
    private PartnerRepositoryI $repository;

    public function __construct(PartnerRepositoryI $repository)
    {
        $this->repository = $repository;
    }
    public function __invoke(NextPage $nextPartnerPage, NumberPerPage $numberPartnerPerPage): PaginationPartner
    {
        $partners = collect($this->repository->all($nextPartnerPage, $numberPartnerPerPage));
        $paginationPartner = PaginationPartner::create(new NextPage(3), new PreviusPage(3), $numberPartnerPerPage, new Total($partners->count()), $partners);
        return $paginationPartner;
    }
}
