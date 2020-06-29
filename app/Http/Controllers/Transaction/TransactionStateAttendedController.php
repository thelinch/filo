<?php

namespace App\Http\Controllers\Transaction;

use Filo\Transactions\Application\AttendedState\TransactionStateTransitionAttended;
use Filo\Transactions\Domain\TransactionId;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class TransactionStateAttendedController extends ApiController
{

    private TransactionStateTransitionAttended $attender;
    public function exceptions(): array
    {
        return [];
    }
    public function __construct()
    {
        $this->attender = App::make(TransactionStateTransitionAttended::class);
    }

    public function __invoke(string $transactionId)
    {
        $this->attender->__invoke(new TransactionId($transactionId));
    }
}
