<?php

return [
    'invite_code' => [
        'expiry_hours' => (int) env('GOTHAM_INVITE_CODE_EXPIRY_HOURS', 6),
        'length' => 10,
    ],

    'verification_code' => [
        'expiry_minutes' => (int) env('GOTHAM_VERIFICATION_CODE_EXPIRY_MINUTES', 60),
        'length' => 6,
        'max_attempts' => 5,
    ],

    'password_reset_code' => [
        'expiry_minutes' => (int) env('GOTHAM_PASSWORD_RESET_CODE_EXPIRY_MINUTES', 15),
        'max_attempts' => (int) env('GOTHAM_PASSWORD_RESET_MAX_ATTEMPTS', 5),
    ],

    'tracking_id' => [
        'prefix' => env('GOTHAM_TRACKING_ID_PREFIX', 'GTX-'),
        // 4 bytes → 8 uppercase hex chars after the prefix.
        'random_bytes' => 4,
    ],

    'telegram' => [
        'bot_handle' => env('GOTHAM_TELEGRAM_BOT_HANDLE', '@GothamExpressBot'),
        'bot_token' => env('TELEGRAM_BOT_TOKEN'),
        'webhook_secret' => env('TELEGRAM_WEBHOOK_SECRET'),
    ],

    'nowpayments' => [
        'api_key' => env('NOWPAYMENTS_API_KEY'),
        'ipn_secret' => env('NOWPAYMENTS_IPN_SECRET'),
        'public_key' => env('NOWPAYMENTS_PUBLIC_KEY'),
        'invoice_endpoint' => 'https://api.nowpayments.io/v1/invoice',
    ],

    'seed_admin' => [
        'name' => env('SEED_ADMIN_NAME', 'Super Admin'),
        'email' => env('SEED_ADMIN_EMAIL'),
        'password' => env('SEED_ADMIN_PASSWORD'),
    ],
];
