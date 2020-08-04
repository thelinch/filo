<?php

namespace Filo\Partners\Domain\Service;

use Filo\Partners\Domain\PartnerId;
use Filo\Partners\Domain\PartnerNotExist;
use Filo\Partners\Domain\PartnerRepositoryI;

//Esta clase es un serviciode dominio por que se va a reutilizar en varios serivicios de aplicacion
class PartnerFinder
{
    private PartnerRepositoryI $repository;
    public function __construct(PartnerRepositoryI $repository)
    {
        $this->repository = $repository;
    }
    public function __invoke(PartnerId $id, $states = [1])
    {
        $partner = $this->repository->search($id, $states);
        if (null == $partner) {
            throw new PartnerNotExist($id);
        }
        return $partner;
    }
}
