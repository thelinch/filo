<?php

namespace Filo\Menus\Domain;

use src\Shared\Domain\DomainError;

class MenuNotExist extends DomainError
{
    private MenuId $id;
    public function __construct(MenuId $id)
    {
        $this->id = $id;
        parent::__construct();
    }
    public function errorCode(): string
    {
        return "menu_not_exist";
    }
    protected function errorMessage(): string
    {
        return sprintf("The Menu does not exist", $this->id->value());
    }
}
