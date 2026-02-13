<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Settings ini memungkinkan Flutter Web (atau frontend lain) untuk
    | mengakses API backend Laravel tanpa diblokir oleh browser.
    |
    | Catatan: Untuk production, ganti '*' dengan domain frontend resmi
    |
    */

    'paths' => [
        'api/*',                // Semua route API
        'sanctum/csrf-cookie',  // Laravel Sanctum
        'admin/*',              // ✅ Tambahan supaya route admin bisa diakses dari Web
    ],

    'allowed_methods' => ['*'],  // Semua HTTP method diizinkan
    'allowed_origins' => ['*'],  // Semua domain diizinkan (dev only)
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],  // Semua header diizinkan
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false, // Tidak perlu credentials untuk dev

];
