<?php

$domain = config('app.domain');

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => [
        '/v1/*',
    ],

    'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE'],

    'allowed_origins' => [],

    'allowed_origins_patterns' => [
        config('app.env') !== 'local'
            ? "~\Ahttps?://{$domain}(/.*)?\z~"
            : "~\Ahttps?://{$domain}:3000(/.*)?\z~",
        config('app.env') !== 'local'
            ? "~\Ahttps?://{$domain}(/.*)?\z~"
            : "~\Ahttps?://{$domain}:8080(/.*)?\z~",
        config('app.env') !== 'local'
            ? "~\Ahttps?://{$domain}(/.*)?\z~"
            : "~\Ahttps?://{$domain}:8088(/.*)?\z~",
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
