<?php

namespace  Filo\Partners\Application\FindCategory;

use Filo\Partners\Domain\Criteria\CategoryCriteria;
use Filo\Partners\Domain\Pagination\PaginationPartner;
use Filo\Partners\Domain\PartnerRepositoryI;
use src\Shared\Domain\Pagination\NextPage;
use src\Shared\Domain\Pagination\NumberPerPage;
use src\Shared\Domain\Pagination\PreviusPage;
use src\Shared\Domain\Pagination\Total;

class PartnerListFindCategory
{
    private PartnerRepositoryI $repository;
    private CategoryCriteria $categoryCriteria;
    public function __construct(PartnerRepositoryI $repository)
    {
        $this->repository = $repository;
    }
    public function __invoke(NextPage $nextPartnerPage, NumberPerPage $numberPartnerPerPage, string $categoryName): PaginationPartner
    {
        $this->categoryCriteria = new CategoryCriteria($categoryName);
        $partners = $this->repository->all($nextPartnerPage, $numberPartnerPerPage);
        $partnerFilterByCategory = collect($this->categoryCriteria->meetCriteria(...$partners));
        $partnerPaginator = PaginationPartner::create($nextPartnerPage, new PreviusPage(2), $numberPartnerPerPage, new Total($partnerFilterByCategory->count()), $partnerFilterByCategory);
        return $partnerPaginator;
    }
}
