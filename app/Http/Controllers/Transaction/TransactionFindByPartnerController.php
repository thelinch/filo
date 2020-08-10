<?php

namespace App\Http\Controllers\Transaction;

use Filo\Partners\Domain\PartnerId;
use Filo\Transactions\Application\FindByPartner\TransactionFindByPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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
    public function __invoke()
    {
        $userAuth = Auth::guard("api")->user();
        if (!$userAuth->hasRole(["administrator"])) {
            return response(["message" => "user not role "]);
        }
        $idPartner = $userAuth->partner->id;
        return  $this->finder->__invoke(new PartnerId($idPartner));
    }
}
