<?php

namespace Filo\Partners\Domain\Criteria;

use Filo\Partners\Domain\Partner;

interface CriteriaPartner
{
    public function meetCriteria(Partner ...$partners): array;
}
