<?php

namespace Filo\Users\Infraestructure;

use Filo\Users\Domain\JwtAuth;
use Filo\Users\Domain\User;
use Filo\Users\Domain\UserDirection;
use Filo\Users\Domain\UserEmail;
use Filo\Users\Domain\UserId;
use Filo\Users\Domain\UserName;
use Filo\Users\Domain\UserNotExist;
use Filo\Users\Domain\UserPassword;
use Filo\Users\Domain\UserPhone;
use Filo\Users\Domain\UserRole;
use Filo\Users\Domain\UserUnauthorized;
use Illuminate\Support\Facades\Auth;

class PassportAuth implements JwtAuth
{
    function login(string $password, string $email): array
    {
        $data = [];
        if (!Auth::attempt(["email" => $email, "password" => $password, "state" => "1"])) {
            throw new UserUnauthorized();
        }
        $user = Auth::user();
        $data = [
            "access_token" => $user->createToken("Personal Access Token")->accessToken

        ];
        return $data;
    }
    function logout()
    {
        $user = Auth::user();
        $user->token()->revoke();
    }
    public function me(): User
    {
        $userModel = Auth::user();
        $userRoles = $userModel->getRoleNames()->map(function ($role) {
            return new UserRole($role);
        })->toArray();
        return new User(
            new UserId($userModel->id),
            new UserDirection($userModel->direction),
            new UserName($userModel->name),
            new UserPhone($userModel->phone),
            new UserPassword($userModel->password),
            new UserEmail($userModel->email),
            ...$userRoles
        );
    }
}
