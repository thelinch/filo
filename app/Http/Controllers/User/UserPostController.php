<?php

namespace App\Http\Controllers\User;

use Filo\Users\Application\Create\UserCreator;
use Filo\Users\Domain\UserCity;
use Filo\Users\Domain\UserDirection;
use Filo\Users\Domain\UserEmail;
use Filo\Users\Domain\UserId;
use Filo\Users\Domain\UserName;
use Filo\Users\Domain\UserPassword;
use Filo\Users\Domain\UserPhone;
use Filo\Users\Domain\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class UserPostController extends ApiController
{

    private UserCreator $userCreator;
    public function __construct()
    {
        $this->userCreator = App::make("userCreator");
    }
    public function exceptions(): array
    {
        return [];
    }

    public function __invoke(Request $request)
    {
        $userParameters = $request->only(["id", "name", "phone", "email", "password", "direction", "city"]);
        $rolesUser = collect(["diner"])->map(fn ($role) => new UserRole($role))->toArray();
        $this->userCreator->__invoke(
            new UserId($userParameters["id"]),
            new UserName($userParameters["name"]),
            new UserPassword($userParameters["password"]),
            new UserEmail($userParameters["email"]),
            new  UserPhone($userParameters["phone"]),
            new UserDirection($userParameters["direction"]),
            new UserCity($userParameters["city"]["id"], "defecto"),
            ...$rolesUser
        );
    }
}
