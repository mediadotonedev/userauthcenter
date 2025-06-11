<?php

return [
    'auth' => [
        'guard' => 'api',
        'token_expiration' => 60, // minutes
        'route_prefix' => 'auth',
    ],
    'api' => [
        'key' => env('AUTH_CENTER_API_KEY', '98|Kfgqg7LRo9sz08mBw4gzvIAbee50a2d'),
        'url' => env('AUTH_CENTER_API_URL', 'http://127.0.0.1:8000/api/clients/'),
    ],
];
