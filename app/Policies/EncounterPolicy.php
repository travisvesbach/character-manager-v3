<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EncounterPolicy
{
    use HandlesAuthorization;

    public function update(User $user, $encounter) {
        return $user->is($encounter->user) || $user->admin;
    }
}
