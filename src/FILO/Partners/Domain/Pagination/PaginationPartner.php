<?php

namespace Filo\Partners\Domain\Pagination;

use Filo\Partners\Domain\Partner;
use Filo\Partners\Domain\PartnerAddress;
use Filo\Partners\Domain\PartnerCategory;
use Filo\Partners\Domain\PartnerDayWork;
use Filo\Partners\Domain\PartnerDescription;
use Filo\Partners\Domain\PartnerDishes;
use Filo\Partners\Domain\PartnerId;
use Filo\Partners\Domain\PartnerName;
use Filo\Partners\Domain\PartnerPhone;
use Filo\Users\Domain\UserId;
use Illuminate\Support\Collection;
use src\Shared\Domain\Pagination\NextPage;
use src\Shared\Domain\Pagination\NumberPerPage;
use src\Shared\Domain\Pagination\Pagination;
use src\Shared\Domain\Pagination\PreviusPage;
use src\Shared\Domain\Pagination\Total;

final class PaginationPartner extends Pagination
{

    public static function create(NextPage $nextPartnerPage, PreviusPage $previusPartnerPage, NumberPerPage $numberPartnerPerPage, Total $totalPartner, Collection $partners)
    {
        //$this->guard();
        //parent::__construct($nextPartnerPage, $previusPartnerPage, $numberPartnerPerPage,  $totalPartner,  $partners);
        return new self($nextPartnerPage, $previusPartnerPage, $numberPartnerPerPage,  $totalPartner,  $partners);
    }
    public function arrayToJson(\Illuminate\Support\Collection $data): array
    {
        $partners = collect([]);
        $data->each(function ($partnerModel) use ($partners) {
            $partnerWorkDays = collect($partnerModel->workdays)->map(function ($dayWork) {
                return new PartnerDayWork(
                    $dayWork->pivot->starttime,
                    $dayWork->pivot->endtime,
                    $dayWork->day,
                    $dayWork->id,
                    $dayWork->pivot->id
                );
            });
            $partners->push(
                new Partner(
                    new PartnerId($partnerModel->id),
                    new PartnerDescription($partnerModel->description),
                    new PartnerName($partnerModel->name),
                    new PartnerDishes($partnerModel->counterdishes),
                    new PartnerCategory($partnerModel->category->id, $partnerModel->category->name),
                    new PartnerAddress($partnerModel->direction),
                    new PartnerPhone("wdwdw"),
                    new UserId($partnerModel->user_id),
                    $partnerWorkDays->toArray()
                )
            );
        });
        return $partners->toArray();
    }
}
