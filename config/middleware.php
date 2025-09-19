<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Middleware Aliases
    |--------------------------------------------------------------------------
    |
    | Here you may define aliases for middleware. These aliases are used
    | to register middleware in the application's middleware stack.
    |
    */

    'aliases' => [
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ],
];
