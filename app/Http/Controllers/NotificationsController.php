<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Notification\Notification;
use App\Services\Notification\Providers\Constants\EmailTypes;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function email()
    {
        $users = User::all();
        $emailTypes = EmailTypes::toString();
        return view('notifications.send-email', compact('users', 'emailTypes'));
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'user' => 'integer|exists:users,id',
            'email_type' => 'integer'
        ]);
        try {
            $notification = resolve(Notification::class);
            $mailable = EmailTypes::toMail($request->email_type);
            $notification->sendEmail(User::find($request->user), new $mailable);
            return back()->with('success', __('notification.email_sent_successfully'));
        } catch (\Throwable $th) {
            return back()->with('failed', __('notification.email_has_problem'));
        }
    }

    public function sms()
    {
        $users = User::all();
        return view('notifications.send-sms', compact('users'));
    }
}
