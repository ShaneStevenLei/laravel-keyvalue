<?php

return [
    /**
     * Cache key prefix
     */
    'prefix'     => env('KEY_VALUE_PREFIX', 'KV_'),

    /**
     * Cache expire times(default 7200 seconds)
     */
    'ttl'        => env('KEY_VALUE_TTL', 7200),
    /**
     * User name column name
     */
    'username'   => env('KEY_VALUE_USERNAME', 'name'),
    /**
     * Middleware
     */
    'middleware' => explode(',', env('KEY_VALUE_MIDDLEWARE', 'web')),
];
