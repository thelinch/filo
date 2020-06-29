<?php

namespace App\Http\Controllers\User;

use Filo\Users\Application\Login\UserLoger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class UserLoginController extends ApiController
{
    private UserLoger $userLoger;

    public function __construct()
    {
        $this->userLoger = App::make(UserLoger::class);
    }
    public function exceptions(): array
    {
        return [];
    }

    public function __invoke(Request $request)
    {
        $userParameter = $request->only(["email", "password"]);
        return $this->userLoger->__invoke($userParameter["password"], $userParameter["email"]);
    }
}
