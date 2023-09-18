<?php

return [

    'auth' => [
        'forgot_password' => [
            'title' => 'Reset Password',
            'description' => 'Reset Password',
        ],
        'login' => [
            'title' => 'Login',
            'description' => 'Login',
        ],
        'reset_password' => [
            'title' => 'Reset Password',
            'description' => 'Reset Password',
        ]
    ],
    'dashboard' => [
        'home' => [
            'index' => [
                'title' => 'Dashboard',
                'description' => 'This is the main dashboard page',
            ]
        ],
        'user' => [
            'index' => [
                'title' => 'User Dashboard',
                'description' => 'Welcome to the user dashboard page',
            ],
            'store' => [
                'redirect' => 'User data has been successfully created!'
            ],
            'update' => [
                'redirect' => 'User data has been successfully updated!'
            ],
            'destroy' => [
                'redirect' => 'User data has been successfully deleted!'
            ]
        ]
    ]
];
