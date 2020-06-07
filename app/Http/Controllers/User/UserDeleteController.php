<?php

namespace App\Http\Controllers\User;

use Filo\Users\Application\Delete\UserDelete;
use Filo\Users\Domain\UserId;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class UserDeleteController extends ApiController
{
    private UserDelete $userDelete;
    public function __construct()
    {
        $this->userDelete = App::make("userDelete");
    }
    public function exceptions(): array
    {
        return [];
    }
    public function __invoke(string $idUser)
    {
        $this->userDelete->__invoke(new UserId($idUser));
    }
}
