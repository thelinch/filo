<?php

namespace App\Http\Controllers\Transaction;

use Filo\Partners\Domain\PartnerId;
use Filo\Transactions\Application\FindByPartner\TransactionFindByPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class TransactionFindByPartnerController extends ApiController
{
    private TransactionFindByPartner $finder;

    public function exceptions(): array
    {
        return [];
    }
    public function __construct()
    {
        $this->finder = App::make("transactionFindByPartner");
    }
    public function __invoke(string $idPartner)
    {
        return  $this->finder->__invoke(new PartnerId($idPartner));
    }
}
