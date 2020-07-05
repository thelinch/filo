<?php

namespace Filo\Menus\Domain;

use Filo\Menus\Domain\Paginate\MenuPaginate;
use Filo\Partners\Domain\PartnerId;
use src\Shared\Domain\Pagination\NextPage;
use src\Shared\Domain\Pagination\NumberPerPage;

interface MenuRepositoryI
{
    function create(Menu $menu): void;
    function search(MenuId $id): ?Menu;
    public function update(Menu $menu): void;
    function delete(Menu $menu): void;
    function all(NextPage $nextPage, NumberPerPage $numberPerPage, PartnerId $partnerId): MenuPaginate;
    function updateVotes(Menu $menu): void;
}
