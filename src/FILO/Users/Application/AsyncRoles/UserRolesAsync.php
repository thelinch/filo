<?php

namespace Filo\Users\Application\AsyncRoles;

use Filo\Partners\Domain\PartnerCreatedDomianEvent;
use Illuminate\Support\Facades\Auth;

class UserRolesAsync
{

    public function handle(PartnerCreatedDomianEvent $partnerCreatedDomianEvent)
    {
        $user = Auth::guard("api")->user();
        if (!$user->hasRole(["administrator"])) {
            $user->syncRoles(["diner", "administrator"]);
        }
    }
}
