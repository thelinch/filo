<?php

namespace Filo\Users\Application\Update;

use Filo\Users\Application\Find\UserFinder;
use Filo\Users\Domain\UserDirection;
use Filo\Users\Domain\UserEmail;
use Filo\Users\Domain\UserId;
use Filo\Users\Domain\UserName;
use Filo\Users\Domain\UserPassword;
use Filo\Users\Domain\UserPhone;
use Filo\Users\Domain\UserRepositoryI;
use Illuminate\Support\Facades\App;

class UserUpdated
{
    private UserFinder $userFinder;
    private UserRepositoryI $repository;
    public function __construct(UserRepositoryI $repository)
    {
        $this->repository = $repository;
        $this->userFinder = App::make("userFinder");
    }
    public function __invoke(
        UserId $id,
        UserName $name,
        UserEmail $email,
        UserPassword $password,
        UserDirection $direction,
        UserPhone $phone
    ) {
        $user = $this->userFinder->__invoke($id);
        $user->update($name, $direction, $email, $password, $phone);
        $this->repository->update($user);
    }
}
