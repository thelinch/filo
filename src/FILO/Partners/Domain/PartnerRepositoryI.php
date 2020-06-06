<?php

namespace Filo\Partners\Domain;

use Filo\Partners\Domain\Pagination\PaginationPartner;
use src\Shared\Domain\Pagination\NextPage;
use src\Shared\Domain\Pagination\NumberPerPage;

interface PartnerRepositoryI
{
    function create(Partner $partner): void;
    function search(PartnerId $id): ?Partner;
    public function update(Partner $partner): void;
    public function delete(PartnerId $id): void;
    public function all(NextPage $nextPage, NumberPerPage $numberPartnerPerPage): PaginationPartner;
}
