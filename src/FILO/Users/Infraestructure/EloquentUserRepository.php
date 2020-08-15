<?php

namespace Filo\Users\Infraestructure;

use Filo\Users\Domain\User;
use Filo\Users\Domain\UserCity;
use Filo\Users\Domain\UserDirection;
use Filo\Users\Domain\UserEmail;
use Filo\Users\Domain\UserId;
use Filo\Users\Domain\UserName;
use Filo\Users\Domain\UserPassword;
use Filo\Users\Domain\UserPhone;
use Filo\Users\Domain\UserRepositoryI;
use Filo\Users\Domain\UserRole;
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
        $userModel->city()->associate($user->city()->id());
        $rolesMap = collect($user->roles())->map(fn (UserRole $role) => [$role->value()])->toArray();
        $userModel->assignRole($rolesMap);
        $userModel->save();
    }
    function findById(UserId $id): ?User
    {
        $userModel = UserModel::where("state", "<>", "0")->with(["roles:id,name", "city:id,name"])->find($id->value());
        if ($userModel == null) {
            return null;
        }
        /*  $userRoles = collect($userModel->roles)->map(fn ($role) => new UserRole($role->name))->toArray();
        return new User(
            new UserId($userModel->id),
            new UserDirection($userModel->direction),
            new UserName($userModel->name),
            new UserPhone($userModel->phone),
            new UserPassword($userModel->password),
            new UserEmail($userModel->email),
            new UserCity($userModel->city->id, $userModel->city->name),
            ...$userRoles
        ); */
        return $this->transformUserModelToUserDomain($userModel);
    }
    function update(User $user): void
    {
        $userModel = UserModel::find($user->id()->value(), ["id", "name", "email", "password", "phone", "direction", "city_id"]);
        $userModel->direction = $user->direction()->value();
        $userModel->email = $user->email()->value();
        $userModel->phone = $user->phone()->value();
        $userModel->password = Hash::make($user->password()->value());
        $userModel->name = $user->name()->value();
        if ($userModel->city_id != $user->city()->id()) {
            $userModel->city()->associate($user->city()->id());
        }
        $userModel->save();
    }

    private function transformUserModelToUserDomain(UserModel $userModel): User
    {
        $userRoles = collect($userModel->roles)->map(fn ($role) => new UserRole($role->name))->toArray();
        return new User(
            new UserId($userModel->id),
            new UserDirection($userModel->direction),
            new UserName($userModel->name),
            new UserPhone($userModel->phone),
            new UserPassword($userModel->password),
            new UserEmail($userModel->email),
            new UserCity($userModel->city->id, $userModel->city->name),
            ...$userRoles
        );
    }
    function delete(User $user): void
    {
        $userModel = UserModel::find($user->id()->value(), ["id", "state"]);
        $userModel->state = "0";
        $userModel->save();
    }
}
