<?php

use App\Mail\TopicCreated;
use App\Models\User;
use App\Services\Notification\Notification;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    $notification = resolve(Notification::class);
//    $notification->sendEmail(User::find(1), new TopicCreated());
//});
Route::get('/', function () {
    return view('home');
});

Route::get('/notification/send-email', 'App\Http\Controllers\NotificationsController@email')
    ->name('notification.form.email');
Route::post('/notification/send-email', 'App\Http\Controllers\NotificationsController@sendEmail')
    ->name('notification.send.email');
Route::get('/notification/send-sms', 'App\Http\Controllers\NotificationsController@sms')
    ->name('notification.form.sms');
Route::post('/notification/send-sms', 'App\Http\Controllers\NotificationsController@sendSms')
    ->name('notification.send.sms');
