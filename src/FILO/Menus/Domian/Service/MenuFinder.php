<?php

namespace Filo\Menus\Domain\Service;

use Filo\Menus\Domain\MenuId;
use Filo\Menus\Domain\MenuNotExist;
use Filo\Menus\Domain\MenuRepositoryI;

//Esta clase es un serviciode dominio por que se va a reutilizar en varios serivicios de aplicacion
class MenuFinder
{
    private MenuRepositoryI $repository;
    public function __construct(MenuRepositoryI $repository)
    {
        $this->repository = $repository;
    }
    public function __invoke(MenuId $id)
    {
        $menu = $this->repository->search($id);
        if (null == $menu) {
            throw new MenuNotExist($id);
        }
        return $menu;
    }
}
