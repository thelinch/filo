<?php

namespace Filo\Partners\Application\AddWorkDay;

use Filo\Partners\Domain\Partner;
use Filo\Partners\Domain\PartnerDayWork;
use Filo\Partners\Domain\PartnerId;
use Filo\Partners\Domain\PartnerRepositoryI;
use Filo\Partners\Domain\Service\PartnerFinder as ServicePartnerFinder;

final class AddWorkDay
{
    private PartnerRepositoryI $repository;
    public function __construct(PartnerRepositoryI $repository)
    {
        $this->repository = $repository;
    }
    public function __invoke(PartnerId $id, PartnerDayWork ...$dayWork)
    {
        $partner = $this->repository->search($id);
        $partner->addAndUpdateWorkDay(...$dayWork);
        $this->repository->updateDaysWork($partner);
    }
}
