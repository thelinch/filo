<?php

namespace Filo\Transactions\Application\FindByPartner;

use Filo\Partners\Application\Find\PartnerFinder;
use Filo\Partners\Domain\PartnerId;
use Filo\Transactions\Domain\TransactionRepository;
use Illuminate\Support\Facades\App;

class TransactionFindByPartner
{

    private TransactionRepository $repository;
    private PartnerFinder $partnerFinder;
    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
        $this->partnerFinder = App::make("partnerFinder");
    }

    public function __invoke(PartnerId $partnerId): array
    {
        $partner = $this->partnerFinder->__invoke($partnerId);
        $transactions = $this->repository->findByPartner($partner->id());
        return $transactions;
    }
}
