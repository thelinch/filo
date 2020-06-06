<?php

namespace Filo\Menus\Infraestructure;

use Filo\Menus\Domain\Menu;
use Filo\Menus\Domain\MenuId;
use Filo\Menus\Domain\MenuName;
use Filo\Menus\Domain\MenuPrice;
use Filo\Menus\Domain\MenuRepositoryI;
use Filo\Menus\Domain\MenuVotes;
use Filo\Menus\Domain\Paginate\MenuPaginate;
use Filo\Partners\Domain\PartnerId;
use Filo\Partners\Infraestructure\PartnerModel;
use src\Shared\Domain\Pagination\NextPage;
use src\Shared\Domain\Pagination\NumberPerPage;
use src\Shared\Domain\Pagination\PreviusPage;
use src\Shared\Domain\Pagination\Total;

class EloquentMenuRepository implements MenuRepositoryI
{
    function create(Menu $menu): void
    {
        $menuModel = new MenuModel();
        $menuModel->id = $menu->id()->value();
        $menuModel->name = $menu->name()->value();
        $menuModel->votes = $menu->votes()->value();
        $menuModel->price = $menu->price()->value();
        $menuModel->partner_id = $menu->partnerId()->value();
        $menuModel->save();
    }
    function all(NextPage $nextPage, NumberPerPage $numberPerPage, PartnerId $partnerId): MenuPaginate
    {
        $menus = PartnerModel::find($partnerId->value())->menus()->paginate($numberPerPage->value())->get();
        $menusPaginate = MenuPaginate::create(
            new NextPage(3),
            new PreviusPage(3),
            $numberPerPage,
            new Total($menus->total()),
            collect($menus->items())
        );
        return $menusPaginate;
    }
    function search(MenuId $id): ?Menu
    {
        $menuModel = MenuModel::where("state", "<>", "0")->find($id->value());
        if (null == $menuModel) {
            return null;
        }

        return  new Menu(new MenuId($menuModel->id), new PartnerId($menuModel->partner_id), new MenuPrice($menuModel->price), new MenuVotes($menuModel->votes), new MenuName($menuModel->name));
    }
    function delete(Menu $menu): void
    {
        $menuModel = MenuModel::find($menu->id()->value());
        $menuModel->state = "0";
        $menuModel->save();
    }
    public function update(Menu $menu): void
    {
        $menuModel = MenuModel::find($menu->id()->value());
        $menuModel->name = $menu->name()->value();
        $menuModel->price = $menu->price()->value();
        $menuModel->save();
    }
}
