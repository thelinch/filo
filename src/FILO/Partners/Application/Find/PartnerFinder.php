<?php

namespace Filo\Partners\Application\Find;

use Filo\Partners\Domain\Partner;
use Filo\Partners\Domain\PartnerId;
use Filo\Partners\Domain\PartnerRepositoryI;
use Filo\Partners\Domain\Service\PartnerFinder as ServicePartnerFinder;

final class PartnerFinder
{
    private ServicePartnerFinder $partnerFinder;
    public function __construct(PartnerRepositoryI $repository)
    {
        $this->partnerFinder = new ServicePartnerFinder($repository);
    }
    public function __invoke(PartnerId $id): Partner
    {
        $partner = $this->partnerFinder->__invoke($id);
        return $partner;
    }
}
