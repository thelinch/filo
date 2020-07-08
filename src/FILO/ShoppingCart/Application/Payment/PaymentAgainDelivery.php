<?php

namespace Filo\ShoppingCart\Application\Payment;

use Filo\Partners\Domain\PartnerId;
use Filo\ShoppingCart\Domain\paymentInterface;
use Filo\Transactions\Application\Create\TransactionCreator;
use Filo\Transactions\Domain\TransactionCode;
use Filo\Transactions\Domain\TransactionId;
use Filo\Transactions\Domain\TransactionTotal;
use Filo\Users\Domain\UserId;
use Illuminate\Support\Facades\App;

class PaymentAgainDelivery implements paymentInterface
{
    private TransactionCreator $transactionCreator;
    private TransactionId $transactionId;
    private PartnerId $partnerId;
    private UserId $userId;
    public function __construct(TransactionId $transactionId, PartnerId $partnerId, UserId $userId)
    {
        $this->transactionCreator = App::make(TransactionCreator::class);
        $this->transactionId = $transactionId;
        $this->partnerId = $partnerId;
        $this->userId = $userId;
    }
    public function pay(float $amount, float $discount, \Filo\ShoppingCart\Domain\ItemShoppingCart ...$items): ?\Filo\Transactions\Domain\TransactionCode
    {
        $transactionCode =  $this->transactionCreator->__invoke($this->userId, $this->transactionId, new TransactionTotal($amount), $this->partnerId, $items);
        return $transactionCode;
    }
}
