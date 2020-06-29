<?php

namespace App\Http\Controllers\User;

use Filo\Users\Application\Auth\AuthUser;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class UserAuthController extends ApiController
{

    private AuthUser $auth;

    public function __construct()
    {
        $this->middleware("auth:api");
        $this->auth = App::make(AuthUser::class);
    }

    public function __invoke()
    {
        return $this->auth->__invoke();
    }
    public function exceptions(): array
    {
        return [];
    }
}
