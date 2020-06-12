<?php

namespace Filo\Users\Infraestructure;

use Filo\Users\Domain\User;
use Filo\Users\Domain\UserDirection;
use Filo\Users\Domain\UserEmail;
use Filo\Users\Domain\UserId;
use Filo\Users\Domain\UserName;
use Filo\Users\Domain\UserPassword;
use Filo\Users\Domain\UserPhone;
use Filo\Users\Domain\UserRepositoryI;
use Illuminate\Support\Facades\Hash;

class EloquentUserRepository implements UserRepositoryI
{

    function create(User $user): void
    {
        $userModel = new UserModel([
            "id" => $user->id()->value(),
            "name" => $user->name()->value(),
            "email" => $user->email()->value(),
            "password" => Hash::make($user->password()->value()),
            "phone" => $user->phone()->value(),
            "direction" => $user->direction()->value()
        ]);
        $userModel->save();
    }
    function findById(UserId $id): ?User
    {
        $userModel = UserModel::where("state", "<>", "0")->find($id->value());
        if ($userModel == null) {
            return null;
        }
        return new User(
            new UserId($userModel->id),
            new UserDirection($userModel->direction),
            new UserName($userModel->name),
            new UserPhone($userModel->phone),
            new UserPassword($userModel->password),
            new UserEmail($userModel->email)
        );
    }
    function update(User $user): void
    {
        $userModel = UserModel::find($user->id()->value());
        $userModel->direction = $user->direction()->value();
        $userModel->email = $user->email()->value();
        $userModel->phone = $user->phone()->value();
        $userModel->password = Hash::make($user->password()->value());
        $userModel->name = $user->name()->value();
        $userModel->save();
    }
    function delete(User $user): void
    {
        $userModel = UserModel::find($user->id()->value());
        $userModel->state = "0";
        $userModel->save();
    }
}
