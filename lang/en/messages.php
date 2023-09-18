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
                'title' => 'Users',
                'description' => 'Manage your users',
            ],
            'create' => [
                'title' => 'New User',
                'description' => 'Manage your users',
            ],
            'store' => [
                'redirect' => 'User data has been successfully created!'
            ],
            'edit' => [
                'title' => 'Edit User',
                'description' => 'Manage your users',
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
