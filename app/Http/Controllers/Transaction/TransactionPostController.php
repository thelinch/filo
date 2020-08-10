<?php

namespace App\Http\Controllers\Transaction;

use Filo\Partners\Domain\PartnerId;
use Filo\ShoppingCart\Application\Payment\PaymentAgainDelivery;
use Filo\ShoppingCart\Domain\ItemShoppingCart;
use Filo\ShoppingCart\Domain\ShoppingCart;
use Filo\Transactions\Application\Create\TransactionCreator;
use Filo\Transactions\Domain\TransactionAmountPayment;
use Filo\Transactions\Domain\TransactionDirection;
use Filo\Transactions\Domain\TransactionId;
use Filo\Transactions\Domain\TransactionPhone;
use Filo\Transactions\Domain\TransactionTotal;
use Filo\Users\Domain\UserId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use src\Shared\Infraestructure\Eloquent\ApiController;

class TransactionPostController extends ApiController
{
    /* private TransactionCreator $creator;
     */
    public function exceptions(): array
    {
        return [];
    }

    public function __construct()
    {
        /* $this->creator = App::make("transactionCreator"); */
    }
    public function __invoke(Request $request)
    {
        $userId = Auth::guard("api")->user()->id;
        $transactionParameter = $request->only(["items", "id", "partnerId", "amountpayment", "phone", "direction"]);
        $items = collect($transactionParameter["items"])->map(function ($item) {
            return new ItemShoppingCart($item["id"], $item["price"], $item["quantity"]);
        })->toArray();
        $shoppingCart = new ShoppingCart(...$items);
        $paymentAgainDelivery = new PaymentAgainDelivery(
            new TransactionId($transactionParameter["id"]),
            new PartnerId($transactionParameter["partnerId"]),
            new UserId($userId),
            new TransactionDirection($transactionParameter["direction"]),
            new TransactionAmountPayment($transactionParameter["amountpayment"]),
            new TransactionPhone($transactionParameter["phone"])
        );
        return  $shoppingCart->pay($paymentAgainDelivery);
        /*   $this->creator->__invoke(
            new UserId($transactionParameter["userId"]),
            new TransactionId($transactionParameter["id"]),
            new TransactionTotal($shoppingCart->calculateTotal()),
            new PartnerId($transactionParameter["partnerId"]),
            $shoppingCart->items()
        ); */
    }
}
