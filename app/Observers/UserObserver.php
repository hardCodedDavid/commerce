<?php

namespace App\Observers;

use App\Models\user;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\Models\user  $user
     * @return void
     */
    public function created(user $user)
    {
        $user->cart()->create(['total' => 0]);
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\Models\user  $user
     * @return void
     */
    public function updated(user $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\Models\user  $user
     * @return void
     */
    public function deleted(user $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\Models\user  $user
     * @return void
     */
    public function restored(user $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\Models\user  $user
     * @return void
     */
    public function forceDeleted(user $user)
    {
        //
    }
}
