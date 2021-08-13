<?php

namespace App\Listeners;

use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

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
        if (!Auth::guard('admin')) {
            CartController::moveSessionCartToDatabase();
            WishlistController::moveSessionWishlistToDatabase();
        }
    }
}
