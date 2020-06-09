<?php

namespace Filo\Users\Domain\Service;

use Filo\Users\Domain\UserId;
use Filo\Users\Domain\UserNotExist;
use Filo\Users\Domain\UserRepositoryI;

class UserFinder
{
    private UserRepositoryI $repository;
    public function __construct(UserRepositoryI $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UserId $id)
    {
        $user = $this->repository->findById($id);
        if ($user == null) {
            throw new UserNotExist($id);
        }
        return $user;
    }
}
