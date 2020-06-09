<?php

namespace Filo\Users\Application\Delete;

use Filo\Users\Application\Find\UserFinder;
use Filo\Users\Domain\UserId;
use Filo\Users\Domain\UserRepositoryI;
use Illuminate\Support\Facades\App;

class UserDelete
{
    private UserRepositoryI $repository;
    private UserFinder $userFinder;
    public function __construct(UserRepositoryI $repository)
    {
        $this->repository = $repository;
        $this->userFinder = App::make("userFinder");
    }

    public function __invoke(UserId $id)
    {
        $user = $this->userFinder->__invoke($id);
        $this->repository->delete($user);
    }
}
