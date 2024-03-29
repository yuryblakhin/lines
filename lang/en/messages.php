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
        ],
        'category' => [
            'index' => [
                'title' => 'Categories',
                'description' => 'Manage your categories',
            ],
            'create' => [
                'title' => 'New Category',
                'description' => 'Manage your categories',
            ],
            'store' => [
                'redirect' => 'Category data has been successfully created!'
            ],
            'edit' => [
                'title' => 'Edit Category',
                'description' => 'Manage your categories',
            ],
            'update' => [
                'redirect' => 'Category data has been successfully updated!'
            ],
            'destroy' => [
                'redirect' => 'Category data has been successfully deleted!'
            ]
        ],
        'product' => [
            'index' => [
                'title' => 'Products',
                'description' => 'Manage your products',
            ],
            'create' => [
                'title' => 'New Product',
                'description' => 'Manage your products',
            ],
            'store' => [
                'redirect' => 'Category data has been successfully created!'
            ],
            'show' => [
                'title' => 'Show Product',
                'description' => 'Manage your products',
            ],
            'edit' => [
                'title' => 'Edit Product',
                'description' => 'Manage your products',
            ],
            'update' => [
                'redirect' => 'Product data has been successfully updated!'
            ],
            'destroy' => [
                'redirect' => 'Product data has been successfully deleted!'
            ]
        ],
        'warehouse' => [
            'index' => [
                'title' => 'Warehouses',
                'description' => 'Manage your warehouses',
            ],
            'create' => [
                'title' => 'New Warehouse',
                'description' => 'Manage your warehouses',
            ],
            'store' => [
                'redirect' => 'Warehouse data has been successfully created!'
            ],
            'show' => [
                'title' => 'Show Warehouse',
                'description' => 'Manage your warehouses',
            ],
            'edit' => [
                'title' => 'Edit Warehouse',
                'description' => 'Manage your warehouses',
            ],
            'update' => [
                'redirect' => 'Warehouse data has been successfully updated!'
            ],
            'destroy' => [
                'redirect' => 'Warehouse data has been successfully deleted!'
            ]
        ],
    ]
];
