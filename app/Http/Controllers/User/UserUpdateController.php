<?php

namespace App\Http\Controllers\User;

use Filo\Users\Application\Update\UserUpdated;
use Filo\Users\Domain\UserDirection;
use Filo\Users\Domain\UserEmail;
use Filo\Users\Domain\UserId;
use Filo\Users\Domain\UserName;
use Filo\Users\Domain\UserPassword;
use Filo\Users\Domain\UserPhone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class UserUpdateController extends ApiController
{
    private UserUpdated $userUpdated;
    public function __construct()
    {
        $this->userUpdated = App::make("userUpdated");
    }
    public function exceptions(): array
    {
        return [];
    }

    public function __invoke(Request $request)
    {
        $userParameters = $request->only(["id", "name", "direction", "password", "phone", "email"]);
        $this->userUpdated->__invoke(
            new UserId($userParameters["id"]),
            new UserName($userParameters["name"]),
            new  UserEmail($userParameters["email"]),
            new  UserPassword($userParameters["password"]),
            new  UserDirection($userParameters["direction"]),
            new UserPhone($userParameters["phone"])
        );
    }
}
