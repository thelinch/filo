<?php

namespace src\Shared\Domain\Pagination;

use src\Shared\Domain\DomainError;

class PreviusPageIsGreaterThaTheNextPageE extends DomainError
{
    public function __construct()
    {
        parent::__construct();
    }
    public function errorCode(): string
    {
        return "previus_page_not_exist";
    }
    protected function errorMessage(): string
    {
        return sprintf("la pagina previa es mayor a la pagina siguiente");
    }
}
