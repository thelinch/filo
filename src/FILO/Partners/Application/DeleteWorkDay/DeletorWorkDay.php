<?php

namespace Filo\Partners\Application\DeleteWorkDay;

use Filo\Partners\Domain\Partner;
use Filo\Partners\Domain\PartnerDayWork;
use Filo\Partners\Domain\PartnerId;
use Filo\Partners\Domain\PartnerRepositoryI;
use Filo\Partners\Domain\Service\PartnerFinder as ServicePartnerFinder;

final class DeletorWorkDay
{
    private PartnerRepositoryI $repository;
    public function __construct(PartnerRepositoryI $repository)
    {
        $this->repository = $repository;
    }
    public function __invoke(PartnerDayWork $dayWork, PartnerId $id)
    {
        $partner = $this->repository->search($id);
        $partner->deleteWorkDay($dayWork);
        $this->repository->updateDaysWork($partner);
    }
}
