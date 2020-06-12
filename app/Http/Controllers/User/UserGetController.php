<?php

namespace App\Http\Controllers\User;

use Filo\Users\Application\Find\UserFinder;
use Filo\Users\Application\Find\UserResponse;
use Filo\Users\Domain\UserId;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class UserGetController extends ApiController
{
    private UserFinder $userFinder;

    public function __construct()
    {
        $this->userFinder = App::make("userFinder");
    }
    public function exceptions(): array
    {
        return [];
    }
    public function __invoke(string $idUser)
    {
        return new UserResponse($this->userFinder->__invoke(new UserId($idUser)));
    }
}
