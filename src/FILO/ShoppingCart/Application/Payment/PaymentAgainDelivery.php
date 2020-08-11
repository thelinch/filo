<?php

namespace Filo\ShoppingCart\Application\Payment;

use Filo\Partners\Domain\PartnerId;
use Filo\Partners\Domain\Service\PartnerFinder;
use Filo\ShoppingCart\Domain\paymentInterface;
use Filo\Transactions\Application\Create\TransactionCreator;
use Filo\Transactions\Domain\TransactionAmountPayment;
use Filo\Transactions\Domain\TransactionCode;
use Filo\Transactions\Domain\TransactionDirection;
use Filo\Transactions\Domain\TransactionId;
use Filo\Transactions\Domain\TransactionPhone;
use Filo\Transactions\Domain\TransactionTotal;
use Filo\Users\Domain\UserId;
use Illuminate\Support\Facades\App;

class PaymentAgainDelivery implements paymentInterface
{
    private TransactionCreator $transactionCreator;
    private TransactionId $transactionId;
    private PartnerId $partnerId;
    private UserId $userId;
    private TransactionDirection $direction;
    private TransactionPhone $phone;
    private TransactionAmountPayment $amountPayment;
    private PartnerFinder $partnerFinder;
    public function __construct(TransactionId $transactionId, PartnerId $partnerId, UserId $userId, TransactionDirection $direction, TransactionAmountPayment $amountPayment, TransactionPhone $phone)
    {
        $this->transactionCreator = App::make(TransactionCreator::class);
        $this->partnerFinder = App::make(PartnerFinder::class);
        $this->transactionId = $transactionId;
        $this->partnerId = $partnerId;
        $this->userId = $userId;
        $this->direction = $direction;
        $this->amountPayment = $amountPayment;
        $this->phone = $phone;
    }
    public function pay(float $amount, float $discount, \Filo\ShoppingCart\Domain\ItemShoppingCart ...$items): ?\Filo\Transactions\Domain\TransactionCode
    {
        $partner = $this->partnerFinder->__invoke($this->partnerId);
        $amount = $amount + $partner->amountDelivery()->value();
        $transactionCode =  $this->transactionCreator->__invoke($this->userId, $this->transactionId, new TransactionTotal($amount), $this->partnerId, $items, $this->direction, $this->phone, $this->amountPayment);
        return $transactionCode;
    }
}
