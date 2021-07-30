<?php

namespace App\Listeners;

use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LoginSuccessful
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function handle(Login $event)
    {
        CartController::moveSessionCartToDatabase();
        WishlistController::moveSessionWishlistToDatabase();
    }
}
