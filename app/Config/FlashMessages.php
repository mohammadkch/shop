<?php

namespace App\Config;

class FlashMessages
{
    public static $success = [
        'user_create_success' => [
            'message' => 'کاربر با موفقیت ایجاد شد.',
            'type' => 'success'
        ],
        'user_update_success' => [
            'message' => 'اطلاعات کاربر با موفقیت بروزرسانی شد.',
            'type' => 'success'
        ],
        'user_delete_success' => [
            'message' => 'کاربر با موفقیت حذف شد.',
            'type' => 'success'
        ],
        'category_create_success' => [
            'message' => 'دسته‌بندی با موفقیت ایجاد شد.',
            'type' => 'success'
        ],
        'category_update_success' => [
            'message' => 'دسته‌بندی با موفقیت بروزرسانی شد.',
            'type' => 'success'
        ],
        'product_create_success' => [
            'message' => 'محصول با موفقیت ایجاد شد.',
            'type' => 'success'
        ],
        'product_update_success' => [
            'message' => 'محصول با موفقیت بروزرسانی شد.',
            'type' => 'success'
        ],
        'invoice_create_success' => [
            'message' => 'فاکتور با موفقیت ایجاد شد.',
            'type' => 'success'
        ],
        'logout_success' => [
            'message' => 'با موفقیت خارج شدید.',
            'type' => 'success'
        ],
        'login_success' => [
            'message' => 'با موفقیت وارد شدید.',
            'type' => 'success'
        ],
        'quote_create_success' => [
            'message' => 'نقل قول با موفقیت ایجاد شد.',
            'type' => 'success'
        ],
        'quote_update_success' => [
            'message' => 'نقل قول با موفقیت بروزرسانی شد.',
            'type' => 'success'
        ],
        // menu1 messages
        'menu_create_success' => [
            'message' => 'منو با موفقیت ایجاد شد.',
            'type' => 'success'
        ],
        'menu_update_success' => [
            'message' => 'منو با موفقیت بروزرسانی شد.',
            'type' => 'success'
        ],
        'menu_delete_success' => [
            'message' => 'منو با موفقیت حذف شد.',
            'type' => 'success'
        ],
    ];

    public static $error = [
        'login_error' => [
            'message' => 'خطا در ورود کاربر.',
            'type' => 'error'
        ],
        'user_create_error' => [
            'message' => 'مشکلی در ایجاد کاربر پیش آمده. لطفاً دوباره تلاش کنید.',
            'type' => 'error'
        ],
        'user_update_error' => [
            'message' => 'مشکلی در بروزرسانی کاربر پیش آمده. لطفاً دوباره تلاش کنید.',
            'type' => 'error'
        ],
        'user_not_found' => [
            'message' => 'کاربر مورد نظر در سیستم وجود ندارد.',
            'type' => 'error'
        ],
        'validation_error' => [
            'message' => 'لطفاً اطلاعات را بررسی کنید.',
            'type' => 'error'
        ],
        'no_result' => [
            'message' => 'هیچ رکوردی با معیارهای جستجوی شما وجود ندارد.',
            'type' => 'warning'
        ],
        'category_not_found' => [
            'message' => 'دسته‌بندی مورد نظر وجود ندارد.',
            'type' => 'error'
        ],
        'category_create_error' => [
            'message' => 'مشکلی در ایجاد دسته‌بندی پیش آمده. لطفاً دوباره تلاش کنید.',
            'type' => 'error'
        ],
        'category_update_error' => [
            'message' => 'مشکلی در بروزرسانی دسته‌بندی پیش آمده. لطفاً دوباره تلاش کنید.',
            'type' => 'error'
        ],
        'product_not_found' => [
            'message' => 'محصول مورد نظر وجود ندارد.',
            'type' => 'error'
        ],
        'product_create_error' => [
            'message' => 'مشکلی در ایجاد محصول پیش آمده. لطفاً دوباره تلاش کنید.',
            'type' => 'error'
        ],
        'product_update_error' => [
            'message' => 'مشکلی در بروزرسانی محصول پیش آمده. لطفاً دوباره تلاش کنید.',
            'type' => 'error'
        ],
        'invoice_create_error' => [
            'message' => 'مشکلی در ایجاد فاکتور پیش آمده. لطفاً دوباره تلاش کنید.',
            'type' => 'error'
        ],
        'invoice_not_found' => [
            'message' => 'فاکتور مورد نظر وجود ندارد.',
            'type' => 'error'
        ],
        'quote_create_error' => [
            'message' => 'مشکلی در ایجاد نقل قول پیش آمده.',
            'type' => 'error'
        ],
        'quote_update_error' => [
            'message' => 'مشکلی در بروزرسانی نقل قول پیش آمده.',
            'type' => 'error'
        ],
        'quote_not_found' => [
            'message' => 'نقل قول مورد نظر وجود ندارد.',
            'type' => 'error'
        ],
        // menu1 errors
        'menu_not_found' => [
            'message' => 'منو مورد نظر وجود ندارد.',
            'type' => 'error'
        ],
        'menu_create_error' => [
            'message' => 'مشکلی در ایجاد منو پیش آمده. لطفاً دوباره تلاش کنید.',
            'type' => 'error'
        ],
        'menu_update_error' => [
            'message' => 'مشکلی در بروزرسانی منو پیش آمده. لطفاً دوباره تلاش کنید.',
            'type' => 'error'
        ],
        'invalid_extension' => [
            'message' => 'پسوند فایل تصویر مجاز نیست.',
            'type' => 'error'
        ],
        'file_too_large' => [
            'message' => 'حجم فایل تصویر بیشتر از حد مجاز است.',
            'type' => 'error'
        ],
    ];

    public static $info = [
        'loading' => [
            'message' => 'در حال پردازش اطلاعات...',
            'type' => 'info'
        ],
        'no_data' => [
            'message' => 'هیچ داده‌ای برای نمایش وجود ندارد.',
            'type' => 'info'
        ],
        'empty_cart' => [
            'message' => 'سبد خرید شما خالی است',
            'type' => 'info'
        ],
    ];

    public static function get($key, $customMessage = null)
    {
        if (isset(self::$success[$key])) {
            $msg = self::$success[$key];
        }
        elseif (isset(self::$error[$key])) {
            $msg = self::$error[$key];
        }
        elseif (isset(self::$info[$key])) {
            $msg = self::$info[$key];
        }
        else {
            return [
                'message' => $customMessage ?? 'عملیات با موفقیت انجام شد.',
                'type' => 'info'
            ];
        }

        if ($customMessage) {
            $msg['message'] = $customMessage;
        }

        return $msg;
    }
}