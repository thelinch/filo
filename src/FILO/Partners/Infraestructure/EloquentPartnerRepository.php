<?php

namespace Filo\Partners\Infraestructure;

use Filo\Partners\Domain\Pagination\PaginationPartner;
use Filo\Partners\Domain\Partner;
use Filo\Partners\Domain\PartnerAddress;
use Filo\Partners\Domain\PartnerAmountDelivery;
use Filo\Partners\Domain\PartnerCategory;
use Filo\Partners\Domain\PartnerCity;
use Filo\Partners\Domain\PartnerDayWork;
use Filo\Partners\Domain\PartnerDescription;
use Filo\Partners\Domain\PartnerDishes;
use Filo\Partners\Domain\PartnerId;
use Filo\Partners\Domain\PartnerName;
use Filo\Partners\Domain\PartnerPhone;
use Filo\Partners\Domain\PartnerPhoto;
use Filo\Partners\Domain\PartnerRepositoryI;
use Filo\Partners\Domain\PartnerState;
use Filo\Users\Domain\UserId;
use Illuminate\Support\Facades\DB;
use src\Shared\Domain\Pagination\NextPage;
use src\Shared\Domain\Pagination\NumberPerPage;
use src\Shared\Domain\Pagination\PreviusPage;
use src\Shared\Domain\Pagination\Total;

class EloquentPartnerRepository implements PartnerRepositoryI
{

    private PartnerModel $model;
    public function __construct(PartnerModel $model)
    {
        $this->model = $model;
    }
    public function create(Partner $partner): void
    {

        DB::beginTransaction();
        $partnerModel = new PartnerModel();
        $partnerModel->id = $partner->id()->value();
        $partnerModel->name = $partner->name()->value();
        $partnerModel->description = $partner->description()->value();
        $partnerModel->counterdishes = $partner->dishes()->value();
        $partnerModel->direction = $partner->address()->value();
        $partnerModel->user_id = $partner->userId()->value();
        $partnerModel->phone = $partner->phone()->value();
        $partnerModel->amountdelivery = $partner->amountDelivery()->value();
        $partnerModel->photo = $partner->photo()->value();
        $partnerModel->petitions = 0;
        $partnerModel->city()->associate($partner->city()->id());
        $partnerModel->category()->associate($partner->category()->id());
        $partnerModel->save();
        collect($partner->daysWork())->each(function ($daywork) use ($partnerModel) {
            $partnerModel->workdays()->attach($daywork->dayId(), [
                "endtime" => $daywork->endTime(),
                "starttime" => $daywork->startTime(),
                "state" => 1,
                "id" => $daywork->id()
            ]);
        });

        DB::commit();
    }
    public function updateDaysWork(Partner $partner)
    {
        DB::beginTransaction();
        $partnerModel = PartnerModel::find($partner->id()->value(), ["id", "name", "description", "city_id", "category_id", "direction", "amountdelivery", "phone", "photo"]);
        $daysWorkModel = $partnerModel->workdays()->get()->map(function ($dayWork) {
            return new PartnerDayWork($dayWork->pivot->starttime, $dayWork->pivot->endtime, $dayWork->day, $dayWork->id, $dayWork->pivot->id);
        });
        $daysWorkPartner = collect($partner->daysWork());
        $isDelete = true;
        $daysWorkAction = collect([]);
        if ($daysWorkPartner->count() < $daysWorkModel->count()) {
            $daysWorkModel->each(function (PartnerDayWork $value, $key) use ($daysWorkPartner, $daysWorkAction) {
                if (!$daysWorkPartner->contains(fn (PartnerDayWork $dayWork, $key) => $value->id() == $dayWork->id())) {
                    $daysWorkAction->push($value);
                }
            });
        } else {
            $isDelete = false;
            // aca es insert o update
            $daysWorkAction = $daysWorkAction->concat($daysWorkPartner);
        }
        if ($daysWorkAction->count() > 0) {
            if ($isDelete) {
                $dayWorkActionFirst = $daysWorkAction->first();
                $partnerModel->workdays()->updateExistingPivot($dayWorkActionFirst->dayId(), [
                    "endtime" => $dayWorkActionFirst->endTime(),
                    "starttime" => $dayWorkActionFirst->startTime(),
                    "state" => $isDelete ? 0 : 1,
                ]);
            } else {

                $daysWorkAction->each(function (PartnerDayWork $dayWorkActionMapP) use ($partnerModel, $daysWorkModel) {
                    if (!$daysWorkModel->contains(fn (PartnerDayWork $dayWork, $key) => $dayWorkActionMapP->id() == $dayWork->id())) {
                        $partnerModel->workdays()->attach($dayWorkActionMapP->dayId(), [
                            "endtime" => $dayWorkActionMapP->endTime(),
                            "starttime" => $dayWorkActionMapP->startTime(),
                            "state" =>  1,
                            "id" => $dayWorkActionMapP->id()
                        ]);
                    } else {
                        $partnerModel->workdays()->updateExistingPivot($dayWorkActionMapP->dayId(), [
                            "endtime" => $dayWorkActionMapP->endTime(),
                            "starttime" => $dayWorkActionMapP->startTime(),
                            "state" => 1,
                        ]);
                    }
                });
            }
        }
        DB::commit();
    }
    public function update(Partner $partner): void
    {
        DB::beginTransaction();
        $partnerModel = PartnerModel::find($partner->id()->value(), ["id", "name", "description", "city_id", "category_id", "direction", "amountdelivery", "phone", "photo"]);
        $partnerModel->name = $partner->name()->value();
        $partnerModel->description = $partner->description()->value();
        $partnerModel->direction = $partner->address()->value();
        $partnerModel->amountdelivery = $partner->amountDelivery()->value();
        $partnerModel->photo = $partner->photo()->value();
        $partnerModel->state = $partner->state()->value();
        $partnerModel->phone = $partner->phone()->value();

        if ($partnerModel->category_id != $partner->category()->id()) {
            $partnerModel->category()->associate($partner->category()->id());
        }
        if ($partnerModel->city_id != $partner->city()->id()) {
            $partnerModel->city()->associate($partner->city()->id());
        }
        $partnerModel->save();
        DB::commit();
    }
    public function delete(PartnerId $id): void
    {
        $partnerModel = PartnerModel::find($id->value(), ["id", "state"]);
        $partnerModel->state = "0";
        $partnerModel->save();
    }
    public function all(NextPage $nextPage, NumberPerPage $numberPartnerPerPage): array
    {
        $partnersModels = PartnerModel::where("state", "<>", 0)
            ->with(["category" => function ($q) {
                $q->select("id", "name");
            }, "workdays", "city" => function ($q) {
                $q->select("id", "name");
            }])->get();
        /* $paginationPartner = PaginationPartner::create(new NextPage(3), new PreviusPage(3), new NumberPerPage($partnersModel->perPage()), new Total($partnersModel->total()), collect($partnersModel->items())); */
        $partners = $partnersModels->map(function ($partnerModel) {
            return $this->transformPartnerModelToPartner($partnerModel);
        })->toArray();
        return $partners;
    }
    public function search(PartnerId $id, $states = [1]): ?Partner
    {
        $partnerModel = $this->model->with(["category" => function ($q) {
            $q->select("id", "name");
        }, "workdays", "city" => function ($q) {
            $q->select("id", "name");
        }])->whereIn("state", $states)->where("id", $id->value())->first();
        if ($partnerModel == null) {
            return null;
        }
        return $this->transformPartnerModelToPartner($partnerModel);
    }
    private function transformPartnerModelToPartner(PartnerModel $partnerModel): Partner
    {
        $partnerWorkDays = collect($partnerModel->workdays)->map(function ($dayWork) {
            return new PartnerDayWork($dayWork->pivot->starttime, $dayWork->pivot->endtime, $dayWork->day, $dayWork->id, $dayWork->pivot->id);
        });
        $partnerDomain = new Partner(
            new PartnerId($partnerModel->id),
            new PartnerDescription($partnerModel->description),
            new PartnerName($partnerModel->name),
            new PartnerDishes($partnerModel->counterdishes),
            new PartnerCategory($partnerModel->category->id, $partnerModel->category->name),
            new PartnerAddress($partnerModel->direction),
            new PartnerPhone($partnerModel->phone),
            new UserId($partnerModel->user_id),
            new PartnerCity($partnerModel->city->id, $partnerModel->city->name),
            new PartnerPhoto($partnerModel->photo),
            new PartnerAmountDelivery($partnerModel->amountdelivery),
            new PartnerState($partnerModel->state),
            ...$partnerWorkDays->toArray()

        );
        return $partnerDomain;
    }
}
