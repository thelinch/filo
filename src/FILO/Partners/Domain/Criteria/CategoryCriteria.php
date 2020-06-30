<?php

namespace Filo\Partners\Domain\Criteria;

use Filo\Partners\Domain\Partner;

class CategoryCriteria implements CriteriaPartner
{
    private int $categoryId;
    public function __construct(int $categoryId)
    {
        $this->categoryId = $categoryId;
    }
    public function meetCriteria(Partner ...$partners): array
    {
        $categoryPartner = collect([]);
        foreach ($partners as $partner) {
            if ($partner->category()->id() == $this->categoryId) {
                $categoryPartner->push($partner);
            }
        }
        return $categoryPartner->toArray();
    }
}
