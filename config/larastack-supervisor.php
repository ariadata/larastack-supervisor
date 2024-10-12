<?php

return [
    'auth' => [
        'rpc' => [
            'host' => env('SUPERVISOR_RPC_HOST', 'supervisor'), // supervisor
            'port' => env('SUPERVISOR_RPC_PORT', 9001),
            'user' => env('SUPERVISOR_RPC_USER', 'user'),
            'pass' => env('SUPERVISOR_RPC_PASS', 'pass'),
        ],
        ]
    ];
