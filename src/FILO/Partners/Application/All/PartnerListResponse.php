<?php

namespace  Filo\Partners\Application\All;

use Filo\Partners\Application\Find\PartnerResponse;
use Filo\Partners\Domain\Pagination\PaginationPartner;
use JsonSerializable;
use src\Shared\Domain\Bus\Query\Response;

class PartnerListResponse implements Response, JsonSerializable
{

    private int $nextPage;
    private int $numberPerPage;
    private array $data;
    public function __construct(PaginationPartner $partnerPaginator)
    {
        $this->nextPage = $partnerPaginator->nextPage()->value();
        $this->numberPerPage = $partnerPaginator->numberPerPage()->value();
        $this->data = collect($partnerPaginator->data())->map(function ($partner) {
            return new  PartnerResponse($partner);
        })->toArray();
    }
    public function jsonSerialize()
    {;
        return [
            "nextPage" => $this->nextPage,
            "numberPerPage" => $this->numberPerPage,
            "data" => $this->data
        ];
    }
}
