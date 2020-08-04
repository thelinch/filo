<?php

namespace Filo\Partners\Domain;

use Filo\Partners\Domain\Pagination\PaginationPartner;
use src\Shared\Domain\Pagination\NextPage;
use src\Shared\Domain\Pagination\NumberPerPage;

interface PartnerRepositoryI
{
    function create(Partner $partner): void;
    public function search(PartnerId $id, $states = [1]): ?Partner;
    public function update(Partner $partner): void;
    public function delete(PartnerId $id): void;
    public function updateDaysWork(Partner $partner);
    public function all(NextPage $nextPage, NumberPerPage $numberPartnerPerPage): array;
}
