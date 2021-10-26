<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiceTablePolicy
{
    use HandlesAuthorization;

    public function update(User $user, $dice_table) {
        return $user->is($dice_table->user) || $user->admin;
    }
}
