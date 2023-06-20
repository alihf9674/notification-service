<?php

use App\Mail\TopicCreated;
use App\Mail\UserRegistered;
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

Route::get('/', function () {
    $notification = resolve(Notification::class);
    $notification->sendSms(User::find(1), "این یک پیام تستی است");
});