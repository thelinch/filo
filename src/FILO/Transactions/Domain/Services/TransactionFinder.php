<?php

namespace Filo\Transactions\Domain\Services;

use Filo\Transactions\Domain\Transaction;
use Filo\Transactions\Domain\TransactionId;
use Filo\Transactions\Domain\TransactionNotExist;
use Filo\Transactions\Domain\TransactionRepository;

class TransactionFinder
{
    private TransactionRepository $repository;


    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(TransactionId $id): Transaction
    {
        $transaction = $this->repository->findById($id);
        if ($transaction == null) {
            throw new TransactionNotExist($id);
        }
        return $transaction;
    }
}
