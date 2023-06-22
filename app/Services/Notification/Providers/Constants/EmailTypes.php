<?php

namespace App\Services\Notification\Providers\Constants;

class EmailTypes
{
    const USER_REGISTERED = 1;
    const TOPIC_CREATED = 2;
    const FORGET_PASSWORD = 3;

    public static function toString(): array
    {
        return [
            self::USER_REGISTERED => 'ثبت نام کاربر',
            self::TOPIC_CREATED=> 'ایجاد مطلب',
            self::FORGET_PASSWORD=> 'فراموشی رمز عبور'
        ];
}
}
