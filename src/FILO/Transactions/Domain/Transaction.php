<?php

namespace Filo\Transactions\Domain;

use Filo\Partners\Domain\PartnerId;
use Filo\Transactions\Application\OnMyWayState\TransactionStateTransitionOnMyWay;
use Filo\Users\Domain\UserId;
use JsonSerializable;
use src\Shared\Domain\Aggregate\AggregateRoot;

class Transaction extends AggregateRoot implements JsonSerializable
{
    private TransactionId $id;
    private TransactionTotal $total;
    private array $details;
    private PartnerId $partnerId;
    private TransactionState $state;
    private UserId $userId;
    private TransactionDirection $direction;
    private TransactionAmountPayment $amountPayment;
    private TransactionPhone $phone;
    private TransactionCode $code;
    public function __construct(
        UserId $userId,
        TransactionId $id,
        TransactionState $state,
        TransactionTotal $total,
        PartnerId $partnerId,
        array $details,
        TransactionCode $code,
        TransactionPhone $phone,
        TransactionAmountPayment $amountPayment,
        TransactionDirection $direction
    ) {
        $this->userId = $userId;
        $this->id = $id;
        $this->total = $total;
        $this->details = $details;
        $this->partnerId = $partnerId;
        $this->code = $code;
        $this->state = $state;
        $this->direction = $direction;
        $this->amountPayment = $amountPayment;
        $this->phone = $phone;
    }

    public static function create(UserId $userId, TransactionId $id, TransactionTotal $total, PartnerId $partnerId, array $details, TransactionCode $code, TransactionPhone $phone, TransactionAmountPayment $amountPayment, TransactionDirection $direction): self
    {
        $transaction = new self($userId, $id, TransactionState::Received(), $total, $partnerId, $details, $code, $phone, $amountPayment, $direction);
        $transaction->record(new TransactionCreatedDomainEvent($id->value(), $total->value(), $partnerId->value(), $details));
        return $transaction;
    }
    public function phone(): TransactionPhone
    {
        return $this->phone;
    }
    public function amountPayment(): TransactionAmountPayment
    {
        return $this->amountPayment;
    }
    public function direction(): TransactionDirection
    {
        return $this->direction;
    }
    public function transitonStateToDelete(): void
    {
        $this->state = TransactionState::cancelled();
        $this->record(new TransactionStateTransitionToDeleteDomainEvent($this->id()->value(), $this->code->value()));
    }
    public function transitonStateToOnMyWay(): void
    {
        $this->state = TransactionState::OnMyWay();
        $this->record(new TransactionStateTransitionToOnMyWayDomainEvent($this->id()->value(), $this->code->value()));
    }
    public function transitonStateToAttended(): void
    {
        $this->state = TransactionState::attended();
        $this->record(new TransactionStateTransitionToAttendedDomainEvent($this->id()->value(), $this->code->value()));
    }
    public function jsonSerialize()
    {
        return [
            "id" => $this->id->value(),
            "items" => $this->details,
            "total" => $this->total()->value(),
            "state" => $this->state()->value(),
            "code" => $this->code->value(),
            "phone" => $this->phone()->value(),
            "direction" => $this->direction()->value(),
            "amountpayment" => $this->amountPayment()->value()
        ];
    }
    public function code(): TransactionCode
    {
        return  $this->code;
    }
    public function generateCode()
    {
    }
    public function userId(): UserId
    {
        return $this->userId;
    }
    public function state(): TransactionState
    {

        return $this->state;
    }
    public function id(): TransactionId
    {
        return $this->id;
    }
    public function total(): TransactionTotal
    {
        return $this->total;
    }

    public function details(): array
    {
        return $this->details;
    }

    public function partnerId(): PartnerId
    {
        return $this->partnerId;
    }
}
