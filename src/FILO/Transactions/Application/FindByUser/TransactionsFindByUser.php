<?php

namespace Filo\Transactions\Application\FindByUser;

use Filo\Partners\Application\Find\PartnerFinder;
use Filo\Partners\Domain\PartnerId;
use Filo\Transactions\Domain\TransactionRepository;
use Filo\Users\Domain\UserId;
use Illuminate\Support\Facades\App;

class TransactionsFindByUser
{

    private TransactionRepository $repository;
    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
        $this->partnerFinder = App::make("partnerFinder");
    }

    public function __invoke(UserId $userId): array
    {
        $transactions = $this->repository->findByUser($userId);
        return $transactions;
    }
}
