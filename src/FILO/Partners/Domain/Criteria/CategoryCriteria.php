<?php

namespace Filo\Partners\Domain\Criteria;

use Filo\Partners\Domain\Partner;

class CategoryCriteria implements CriteriaPartner
{
    private string $name;
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    public function meetCriteria(Partner ...$partners): array
    {
        $categoryPartner = collect([]);
        foreach ($partners as $partner) {
            if ($partner->category()->name() == $this->name) {
                $categoryPartner->push($partner);
            }
        }
        return $categoryPartner->toArray();
    }
}
