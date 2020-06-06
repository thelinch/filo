<?php

namespace  Filo\Partners\Application\Delete;

use Filo\Partners\Application\Find\PartnerFinder;
use Filo\Partners\Domain\PartnerId;
use Filo\Partners\Domain\PartnerRepositoryI;
use Illuminate\Support\Facades\App;

class PartnerDelete
{

    private PartnerRepositoryI $repository;
    private PartnerFinder $partnerFinder;
    public function __construct(PartnerRepositoryI $repository)
    {
        $this->repository = $repository;
        $this->partnerFinder = App::make("partnerFinder");
    }
    public function __invoke(PartnerId $id)
    {
        $this->partnerFinder->__invoke($id);
        $this->repository->delete($id);
    }
}
