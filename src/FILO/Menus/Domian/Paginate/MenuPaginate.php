<?php

namespace Filo\Menus\Domain\Paginate;

use Filo\Menus\Domain\Menu;
use Filo\Menus\Domain\MenuDescription;
use Filo\Menus\Domain\MenuId;
use Filo\Menus\Domain\MenuName;
use Filo\Menus\Domain\MenuPhoto;
use Filo\Menus\Domain\MenuPrice;
use Filo\Menus\Domain\MenuVotes;
use Filo\Partners\Domain\PartnerId;
use Illuminate\Support\Collection;
use src\Shared\Domain\Pagination\NextPage;
use src\Shared\Domain\Pagination\NumberPerPage;
use src\Shared\Domain\Pagination\Pagination;
use src\Shared\Domain\Pagination\PreviusPage;
use src\Shared\Domain\Pagination\Total;

class MenuPaginate extends Pagination
{

    public static function create(NextPage $nextPartnerPage, PreviusPage $previusPartnerPage, NumberPerPage $numberPartnerPerPage, Total $totalPartner, Collection $menus)
    {
        return new self($nextPartnerPage, $previusPartnerPage, $numberPartnerPerPage,  $totalPartner,  $menus);
    }
    public function arrayToJson(\Illuminate\Support\Collection $data): array
    {
        $menus = [];
        $menus = $data->map(function ($menuModel) {

            return new Menu(
                new MenuId($menuModel->id),
                new PartnerId($menuModel->partner_id),
                new MenuPrice($menuModel->price),
                new MenuVotes($menuModel->votes),
                new MenuName($menuModel->name),
                new MenuPhoto($menuModel->photo),
                new MenuDescription($menuModel->description)
            );
        })->toArray();
        return $menus;
    }
}
