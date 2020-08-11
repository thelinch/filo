<?php

namespace Filo\Transactions\Infraestructure;

use Filo\Menus\Domain\Menu;
use Filo\Menus\Domain\MenuDescription;
use Filo\Menus\Domain\MenuId;
use Filo\Menus\Domain\MenuName;
use Filo\Menus\Domain\MenuPhoto;
use Filo\Menus\Domain\MenuPrice;
use Filo\Menus\Domain\MenuVotes;
use Filo\Partners\Domain\PartnerId;
use Filo\Transactions\Domain\Transaction;
use Filo\Transactions\Domain\TransactionAmountPayment;
use Filo\Transactions\Domain\TransactionCode;
use Filo\Transactions\Domain\TransactionDetail;
use Filo\Transactions\Domain\TransactionDirection;
use Filo\Transactions\Domain\TransactionId;
use Filo\Transactions\Domain\TransactionPhone;
use Filo\Transactions\Domain\TransactionRepository;
use Filo\Transactions\Domain\TransactionState;
use Filo\Transactions\Domain\TransactionTotal;
use Filo\Transactions\Infraestructure\ConcretState\Cancelled;
use Filo\Transactions\Infraestructure\ConcretState\Received;
use Filo\Users\Domain\UserId;
use Illuminate\Support\Facades\DB;

class EloquentTransaction implements TransactionRepository
{
    private TransactionModel $model;
    public function __construct(TransactionModel $model)
    {
        $this->model = $model;
    }
    function create(Transaction $transaction): void
    {
        DB::beginTransaction();
        $transactionModel = $this->model->create([
            "id" => $transaction->id()->value(),
            "user_id" => $transaction->userId()->value(),
            "total" => $transaction->total()->value(),
            "partner_id" => $transaction->partnerId()->value(),
            "code" => $transaction->code()->value(),
            "direction" => $transaction->direction()->value(),
            "phone" => $transaction->phone()->value(),
            "amountpayment" => $transaction->amountPayment()->value()
        ]);
        $transactionDetails = collect($transaction->details())->map(function ($item) {
            return [
                "quantity" => $item->quantity(),
                "menu_id" => $item->id(),
            ];
        });
        $transactionModel->details()->createMany($transactionDetails);
        DB::commit();
    }
    function findByPartner(PartnerId $partnerId): array
    {
        $transactions = $this->model->with(["details:id,quantity,transaction_id,menu_id", "details.menu:id,price,votes,name,photo,description", "partner:id,name"])->where(["partner_id" => $partnerId->value()])->orderBy("created_at", "DESC")->get();
        $transactions = $transactions->map(function ($transactionModel) {
            return $this->transformTransactionModelToTransactionDomain($transactionModel);
        })->toArray();
        return $transactions;
    }
    function findByUser(UserId $id): array
    {
        $transactions = $this->model->with(["details:id,quantity,transaction_id,menu_id", "details.menu:id,price,votes,name,photo,description", "partner:id,name"])->where(["user_id" => $id->value()])->orderBy("created_at", "DESC")->get();
        $transactions = $transactions->map(function ($transactionModel) {
            return $this->transformTransactionModelToTransactionDomain($transactionModel);
        })->toArray();
        return $transactions;
    }
    private function transformTransactionModelToTransactionDomain(TransactionModel $transactionModel): Transaction
    {
        $details = collect($transactionModel->details)->map(function ($detail) use ($transactionModel) {
            return new  TransactionDetail($detail->id, new Menu(
                new MenuId($detail->menu->id),
                new PartnerId($transactionModel->partner_id),
                new MenuPrice($detail->menu->price),
                new MenuVotes($detail->menu->votes),
                new MenuName($detail->menu->name),
                new MenuPhoto($detail->menu->photo),
                new MenuDescription($detail->menu->description)
            ), $detail->quantity);
        })->toArray();
        $transaction = new Transaction(
            new UserId($transactionModel->user_id),
            new TransactionId($transactionModel->id),
            new TransactionState($transactionModel->state->name()),
            new TransactionTotal($transactionModel->total),
            new PartnerId($transactionModel->partner_id),
            $details,
            new TransactionCode($transactionModel->code),
            new TransactionPhone($transactionModel->phone),
            new TransactionAmountPayment($transactionModel->amountpayment),
            new TransactionDirection($transactionModel->direction)
        );
        $transaction->setPartnerName($transactionModel->partner->name);
        $transaction->setCreatedAt($transactionModel->created_at);
        return $transaction;
    }
    function findById(TransactionId $id): ?Transaction
    {
        $transactionModel = $this->model->with(["details:id,quantity,transaction_id,menu_id", "details.menu:id,price,votes,name,photo,description", "partner:id,name"])->find($id->value());
        if ($transactionModel == null) {
            return null;
        }
        return $this->transformTransactionModelToTransactionDomain($transactionModel);
    }
}
