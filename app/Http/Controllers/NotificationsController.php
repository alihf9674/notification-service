<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Jobs\SendSms;
use App\Models\User;
use App\Services\Notification\Notification;
use App\Services\Notification\Providers\Constants\EmailTypes;
use App\Services\Notification\Providers\Exceptions\UserDoesNotHavePhoneNumber;
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
            $mailable = EmailTypes::toMail($request->email_type);
            SendEmail::dispatch(User::find($request->user), new $mailable);
            return redirect()->back()->with('success', __('notification.email_sent_successfully'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', __('notification.email_has_problem'));
        }
    }

    public function sms()
    {
        $users = User::all();
        return view('notifications.send-sms', compact('users'));
    }

    public function sendSms(Request $request)
    {
        $request->validate([
            'user' => 'integer|exists:user,id',
            'test' => 'string|max:256'
        ]);
        try {
            SendSms::dispatch(User::find($request->user), $request->test);
            return redirect()->back()->with('success', __('notification.email_sent_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', __('notification.sms_has_problem'));
        }
    }
}
