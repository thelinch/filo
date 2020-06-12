<?php

namespace Filo\Transactions\Application\Delete;

use Filo\Transactions\Domain\Services\TransactionFinder;
use Filo\Transactions\Domain\TransactionId;
use Filo\Transactions\Domain\TransactionRepository;
use Illuminate\Support\Facades\App;

class TransactionDeleter
{
    private TransactionFinder $finder;
    private TransactionRepository $repository;
    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
        $this->finder = App::make("transactionFinder");
    }
    public function __invoke(TransactionId $id)
    {

        $transaction = $this->finder->__invoke($id);
        if ($transaction->state()->isAllowedTransitionToCancelled()) {
            $transaction->transitonStateToDelete();
            $this->repository->cancelled($transaction);
        }
    }
}
