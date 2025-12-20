<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines which origins are allowed to make requests
    | into your application.
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'profile/*'],

    'allowed_methods' => ['*'],

    // Add your deployed frontend and common local dev origins below
    'allowed_origins' => [
        'https://sweet-bite-bakery-system.vercel.app',
        'http://localhost',
        'http://localhost:3000',
        'http://127.0.0.1:5173',
        'http://127.0.0.1:8000',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
