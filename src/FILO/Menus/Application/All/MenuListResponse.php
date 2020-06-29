<?php

namespace Filo\Menus\Application\All;

use Filo\Menus\Application\Find\MenuResponse;
use Filo\Menus\Domain\Paginate\MenuPaginate;
use JsonSerializable;
use src\Shared\Domain\Bus\Query\Response;

class MenuListResponse implements Response, JsonSerializable
{

    private int $nextPage;
    private int $numberPerPage;
    private array $data;
    public function __construct(MenuPaginate $menuPaginator)
    {
        $this->nextPage = $menuPaginator->nextPage()->value();
        $this->numberPerPage = $menuPaginator->numberPerPage()->value();
        $this->data = collect($menuPaginator->data())->map(function ($menuModel) {
            return new  MenuResponse($menuModel);
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
