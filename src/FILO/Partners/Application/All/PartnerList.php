<?php

namespace  Filo\Partners\Application\All;

use Filo\Partners\Domain\Pagination\PaginationPartner;
use Filo\Partners\Domain\PartnerRepositoryI;
use src\Shared\Domain\Pagination\NextPage;
use src\Shared\Domain\Pagination\NumberPerPage;

class PartnerList
{
    private PartnerRepositoryI $repository;

    public function __construct(PartnerRepositoryI $repository)
    {
        $this->repository = $repository;
    }
    public function __invoke(NextPage $nextPartnerPage, NumberPerPage $numberPartnerPerPage): PaginationPartner
    {
        return $this->repository->all($nextPartnerPage, $numberPartnerPerPage);
    }
}
