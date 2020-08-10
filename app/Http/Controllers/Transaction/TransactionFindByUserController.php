<?php

namespace App\Http\Controllers\Transaction;

use Filo\Transactions\Application\FindByUser\TransactionsFindByUser;
use Filo\Users\Domain\UserId;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use src\Shared\Infraestructure\Eloquent\ApiController;

class TransactionFindByUserController extends ApiController
{
    private TransactionsFindByUser $finderTransaction;


    public function __construct()
    {
        $this->finderTransaction = App::make(TransactionsFindByUser::class);
    }
    public function exceptions(): array
    {
        return [];
    }

    public function __invoke()
    {
        $userId = Auth::guard("api")->user()->id;
        return $this->finderTransaction->__invoke(new UserId($userId));
    }
}
