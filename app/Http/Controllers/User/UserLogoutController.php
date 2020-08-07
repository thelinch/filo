<?php

namespace App\Http\Controllers\User;

use Filo\Users\Application\Login\UserLoger;
use Filo\Users\Domain\JwtAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class UserLogoutController extends ApiController
{
    private JwtAuth $auth;

    public function __construct(JwtAuth $auth)
    {
        $this->auth = $auth;
    }
    public function exceptions(): array
    {
        return [];
    }

    public function __invoke(Request $request)
    {
        $this->auth->logout();
    }
}
