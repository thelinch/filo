<?php

namespace App\Http\Controllers\Transaction;

use Filo\Transactions\Application\Delete\TransactionDeleter;
use Filo\Transactions\Domain\TransactionId;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class TransactionCancelledGetController extends ApiController
{
    private TransactionDeleter $deletor;
    public function __construct()
    {
        $this->deletor = App::make(TransactionDeleter::class);
    }
    public function exceptions(): array
    {
        return [];
    }
    public function __invoke(string $transactionId)
    {
        $this->deletor->__invoke(new TransactionId($transactionId));
    }
}
