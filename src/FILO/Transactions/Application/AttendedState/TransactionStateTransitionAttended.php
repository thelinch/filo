<?php

namespace Filo\Transactions\Application\AttendedState;

use Filo\Transactions\Domain\Services\TransactionFinder;
use Filo\Transactions\Domain\TransactionId;
use Filo\Transactions\Domain\TransactionStateRepository;
use Illuminate\Support\Facades\App;

class TransactionStateTransitionAttended
{
    private TransactionStateRepository $repository;
    private TransactionFinder $finder;
    public function __construct(TransactionStateRepository $repository)
    {
        $this->repository = $repository;
        $this->finder = App::make("transactionFinder");
    }
    public function __invoke(TransactionId $id)
    {
        $transaction = $this->finder->__invoke($id);
        if ($transaction->state()->isAllowedTransitionToAttended()) {
            $transaction->transitonStateToAttended();
            $this->repository->attended($transaction);
        }
    }
}
