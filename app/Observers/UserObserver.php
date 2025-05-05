<?php

namespace App\Observers;

use App\Models\Role;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    // app/Observers/UserObserver.php
    public function created(User $user): void
    {
        if (!$user->hasAnyRole()) {
            $user->assignRole('customer');
        }
    }
}