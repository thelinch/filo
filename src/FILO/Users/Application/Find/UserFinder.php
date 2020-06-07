<?php

namespace Filo\Users\Application\Find;

use Filo\Users\Domain\Service\UserFinder as ServiceUserFinder;
use Filo\Users\Domain\UserId;
use Filo\Users\Domain\UserRepositoryI;

class UserFinder
{
    private ServiceUserFinder $ServiceUserFinder;

    public function __construct(UserRepositoryI $repository)
    {
        $this->ServiceUserFinder = new ServiceUserFinder($repository);
    }

    public function __invoke(UserId $id)
    {
        return $this->ServiceUserFinder->__invoke($id);
    }
}
