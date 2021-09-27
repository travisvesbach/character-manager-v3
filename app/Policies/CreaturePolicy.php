<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CreaturePolicy
{
    use HandlesAuthorization;

    public function update(User $user, $creature) {
        return $user->is($creature->user) || $user->admin;
    }
}
