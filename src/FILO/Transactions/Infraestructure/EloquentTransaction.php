<?php

namespace Filo\Transactions\Infraestructure;

use Filo\Menus\Domain\Menu;
use Filo\Menus\Domain\MenuId;
use Filo\Menus\Domain\MenuName;
use Filo\Menus\Domain\MenuPrice;
use Filo\Menus\Domain\MenuVotes;
use Filo\Partners\Domain\PartnerId;
use Filo\Transactions\Domain\Transaction;
use Filo\Transactions\Domain\TransactionCode;
use Filo\Transactions\Domain\TransactionDetail;
use Filo\Transactions\Domain\TransactionId;
use Filo\Transactions\Domain\TransactionRepository;
use Filo\Transactions\Domain\TransactionTotal;
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
            "state" => $transaction->state,
            "code" => $transaction->code()->value()
        ]);

        collect($transaction->details())->each(function ($item) use ($transactionModel) {
            $transactionModel->details()->save([
                "quantity" => $item->quantity(),
                "menu_id" => $item->menuId()->value(),
            ]);
        });
        DB::commit();
    }
    function findByPartner(PartnerId $partnerId): ?array
    {
        $transactions = $this->model->with(["details"])->where(["partner_id" => $partnerId->value(), "state" => "1"])->get();
        if ($transactions->isEmpty()) {
            return null;
        }
        $transactions = $transactions->map(function ($transactionModel) {
            $details = collect($transactionModel->details)->map(function ($detail) use ($transactionModel) {
                return new  TransactionDetail($detail->id, new Menu(
                    new MenuId($detail->menu->id),
                    new PartnerId($transactionModel->partner_id),
                    new MenuPrice($detail->menu->price),
                    new MenuVotes($detail->menu->votes),
                    new MenuName($detail->menu->name)
                ), $detail->quantity);
            })->toArray();
            return new Transaction(
                new UserId($transactionModel->user_id),
                new TransactionId($transactionModel->id),
                $transactionModel->state,
                new TransactionTotal($transactionModel->total),
                new PartnerId($transactionModel->partner_id),
                $details,
                new TransactionCode($transactionModel->code)
            );
        })->toArray();
        return $transactions;
    }
    function findByUser(UserId $id): ?array
    {
        $transactions = $this->model->with(["details.menu"])->where(["user_id" => $id->value(), "state" => "1"])->get();
        if ($transactions->isEmpty()) {
            return null;
        }
        $transactions = $transactions->map(function ($transactionModel) {
            $details = collect($transactionModel->details)->map(function ($detail) use ($transactionModel) {
                return new  TransactionDetail($detail->id, new Menu(
                    new MenuId($detail->menu->id),
                    new PartnerId($transactionModel->partner_id),
                    new MenuPrice($detail->menu->price),
                    new MenuVotes($detail->menu->votes),
                    new MenuName($detail->menu->name)
                ), $detail->quantity);
            })->toArray();
            return new Transaction(
                new UserId($transactionModel->user_id),
                new TransactionId($transactionModel->id),
                $transactionModel->state,
                new TransactionTotal($transactionModel->total),
                new PartnerId($transactionModel->partner_id),
                $details,
                new TransactionCode($transactionModel->code)
            );
        })->toArray();
        return $transactions;
    }
}
