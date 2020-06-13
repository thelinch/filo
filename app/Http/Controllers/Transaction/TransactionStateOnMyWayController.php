<?php

namespace App\Http\Controllers\Transaction;

use Filo\Transactions\Application\OnMyWayState\TransactionStateTransitionOnMyWay;
use Filo\Transactions\Domain\TransactionId;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class TransactionStateOnMyWayController extends ApiController
{
    private TransactionStateTransitionOnMyWay $transactionState;

    public function __construct()
    {
        $this->transactionState = App::make(TransactionStateTransitionOnMyWay::class);
    }

    public function exceptions(): array
    {
        return [];
    }
    public function __invoke(string $transactionId)
    {
        $this->transactionState->__invoke(new TransactionId($transactionId));
    }
}
