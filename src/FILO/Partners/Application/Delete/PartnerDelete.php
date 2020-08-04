<?php

namespace  Filo\Partners\Application\Delete;

use Filo\Partners\Domain\PartnerId;
use Filo\Partners\Domain\PartnerRepositoryI;
use Filo\Partners\Domain\Service\PartnerFinder;
use Illuminate\Support\Facades\App;

class PartnerDelete
{

    private PartnerRepositoryI $repository;
    private PartnerFinder $partnerFinder;
    public function __construct(PartnerRepositoryI $repository)
    {
        $this->repository = $repository;
        $this->partnerFinder = App::make(PartnerFinder::class);
    }
    public function __invoke(PartnerId $id)
    {
        $partner = $this->partnerFinder->__invoke($id, [1, 0]);
        $partner->toogleState();
        $this->repository->update($partner);
    }
}
