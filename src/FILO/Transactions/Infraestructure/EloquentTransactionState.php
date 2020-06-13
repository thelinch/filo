<?php

namespace Filo\Transactions\Infraestructure;

use Filo\Transactions\Domain\Transaction;
use Filo\Transactions\Domain\TransactionStateRepository;
use Filo\Transactions\Infraestructure\ConcretState\Attended;
use Filo\Transactions\Infraestructure\ConcretState\Cancelled;
use Filo\Transactions\Infraestructure\ConcretState\OnMyWay;

class EloquentTransactionState implements TransactionStateRepository
{
    private TransactionModel $model;
    public function __construct(TransactionModel $model)
    {
        $this->model = $model;
    }
    function cancelled(Transaction $transaction): void
    {
        $transactionModel = $this->model->find($transaction->id()->value());
        $transactionModel->state->transitionTo(Cancelled::class);
    }
    function onMyWay(Transaction $transaction): void
    {
        $transactionModel = $this->model->find($transaction->id()->value());
        $transactionModel->state->transitionTo(OnMyWay::class);
    }
    function attended(Transaction $transaction): void
    {
        $transactionModel = $this->model->find($transaction->id()->value());
        $transactionModel->state->transitionTo(Attended::class);
    }
}
