<?php

use App\Models\User;
use App\Models\Administrador;

return [

    // Authentication Defaults
    

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'admin'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    // Authentication Guards
   

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // GUARD PERSONALIZADO PARA ADMINISTRADORES DE FARMACIA
        'admin' => [
            'driver' => 'session',
            'provider' => 'administradores',
        ],
    ],

    // User Providers
    

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', User::class),
        ],

        // PROVEEDOR ELOQUENT PARA EL MODELO ADMINISTRADOR
        'administradores' => [
            'driver' => 'eloquent',
            'model' => Administrador::class,
        ],
    ],

    // Resetting Passwords
   

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    //  Password Confirmation Timeout
    
    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
