<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Environnement FedaPay
    |--------------------------------------------------------------------------
    | 'sandbox' pour les tests
    | 'live' pour la production
    */
    'environment' => env('FEDAPAY_ENVIRONMENT', 'sandbox'),

    /*
    |--------------------------------------------------------------------------
    | Mode Simulation (Développement Local)
    |--------------------------------------------------------------------------
    | Active le mode simulation pour tester sans vraie transaction
    */
    'simulate' => env('FEDAPAY_SIMULATE', false),

    /*
    |--------------------------------------------------------------------------
    | Configuration Sandbox (Tests)
    |--------------------------------------------------------------------------
    */
    'sandbox' => [
        'public_key' => env('FEDAPAY_SANDBOX_PUBLIC_KEY', ''),
        'secret_key' => env('FEDAPAY_SANDBOX_SECRET_KEY', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Configuration Live (Production)
    |--------------------------------------------------------------------------
    */
    'live' => [
        'public_key' => env('FEDAPAY_LIVE_PUBLIC_KEY', ''),
        'secret_key' => env('FEDAPAY_LIVE_SECRET_KEY', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Webhook Secret
    |--------------------------------------------------------------------------
    */
    'webhook_secret' => env('FEDAPAY_WEBHOOK_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Frais de transaction (%)
    |--------------------------------------------------------------------------
    */
    'transaction_fee' => env('FEDAPAY_TRANSACTION_FEE', 1.5),

    /*
    |--------------------------------------------------------------------------
    | Montants par défaut (XOF)
    |--------------------------------------------------------------------------
    */
    'default_amounts' => [
        'article' => 500,    // 500 FCFA par article
        'monthly' => 2000,   // 2000 FCFA par mois
        'annual' => 20000,   // 20000 FCFA par an
    ],

    /*
    |--------------------------------------------------------------------------
    | URLs de callback
    |--------------------------------------------------------------------------
    */
    'callback_url' => env('APP_URL') . '/payment/callback',
    'webhook_url' => env('APP_URL') . '/payment/webhook',
];

