<?php

namespace Filo\Partners\Infraestructure;

use Filo\Partners\Domain\Pagination\PaginationPartner;
use Filo\Partners\Domain\Partner;
use Filo\Partners\Domain\PartnerAddress;
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
    public function update(Partner $partner): void
    {
        $partnerModel = PartnerModel::find($partner->id()->value());
        $partnerModel->name = $partner->name()->value();
        $partnerModel->description = $partner->description()->value();
        $partnerModel->direction = $partner->address()->value();
        $partnerModel->save();
    }
    public function delete(PartnerId $id): void
    {
        $partnerModel = PartnerModel::find($id->value());
        $partnerModel->state = "0";
        $partnerModel->save();
    }
    public function all(NextPage $nextPage, NumberPerPage $numberPartnerPerPage): PaginationPartner
    {
        $partnersModel = PartnerModel::where("state", "<>", 0)->paginate($numberPartnerPerPage->value());
        $paginationPartner = PaginationPartner::create(new NextPage(3), new PreviusPage(3), new NumberPerPage($partnersModel->perPage()), new Total($partnersModel->total()), collect($partnersModel->items()));
        return $paginationPartner;
    }
    public function search(PartnerId $id): ?Partner
    {
        $partnerModel = $this->model->with(["category", "workdays", "city"])->find($id->value());
        if ($partnerModel == null) {
            return null;
        }
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
            ...$partnerWorkDays->toArray()

        );
        return $partnerDomain;
    }
}
