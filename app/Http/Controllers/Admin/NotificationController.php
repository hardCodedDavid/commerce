<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\CustomNotificationByEmail;

class NotificationController extends Controller
{
    public function index()
    {
        return view('admin.notifications.index');
    }

    public function show()
    {
        return view('admin.notifications.show');
    }

    public static function sendAdminRegistrationEmailNotification($admin, $password)
    {
        $msg = 'Welcome to '.env('APP_NAME').'.<br>
                An administrator account with role of <b>'.$admin->roles()->first()['name'].'</b> has been created for you, find your login credentials below.<br><br>
                Email: <b>'.$admin['email'].'</b><br>
                Password: <b>'.$password.'</b><br>';
        $admin->notify(new CustomNotificationByEmail('Administrator Welcome', $msg, 'Login to Dashboard', route('admin.login')));
    }
}
