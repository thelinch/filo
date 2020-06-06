<?php

namespace src\Shared\Domain\Pagination;

use Illuminate\Support\Collection;

abstract class Pagination
{
    private NextPage $nextPage;
    private PreviusPage $previusPage;
    private NumberPerPage $numberPerPage;
    private Total $total;
    private array $data;
    public function __construct(NextPage $nextPage, PreviusPage $previusPage, NumberPerPage $numberPerPage, Total $total, Collection $data)
    {
        $this->guard($previusPage, $nextPage);
        $this->nextPage = $nextPage;
        $this->previusPage = $previusPage;
        $this->numberPerPage = $numberPerPage;
        $this->total = $total;
        $this->data = $this->arrayToJson($data);
    }
    public function nextPage(): NextPage
    {
        return $this->nextPage;
    }
    private function guard(PreviusPage $previusPage, NextPage $nextPage)
    {
        if ($previusPage->value() > $nextPage->value()) {
            throw new PreviusPageIsGreaterThaTheNextPageE();
        }
    }
    abstract function arrayToJson(Collection $data): array;

    public function previusPage(): PreviusPage
    {
        return $this->previusPage;
    }

    public function data(): array
    {
        return $this->data;
    }
    public function numberPerPage(): NumberPerPage
    {
        return $this->numberPerPage;
    }

    public function total(): Total
    {
        return $this->total;
    }
}
