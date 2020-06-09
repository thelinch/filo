<?php

namespace Filo\Users\Application\Create;

use Filo\Users\Domain\User;
use Filo\Users\Domain\UserDirection;
use Filo\Users\Domain\UserEmail;
use Filo\Users\Domain\UserId;
use Filo\Users\Domain\UserName;
use Filo\Users\Domain\UserPassword;
use Filo\Users\Domain\UserPhone;
use Filo\Users\Domain\UserRepositoryI;

class UserCreator
{

    private UserRepositoryI $repository;

    public function __construct(UserRepositoryI $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UserId $id, UserName $name, UserPassword $password, UserEmail $email, UserPhone $phone, UserDirection $direction)
    {
        $user =   User::create($id, $name, $direction, $email, $password, $phone);
        $this->repository->create($user);
    }
}
