<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Auth extends BaseConfig
{
    public array $roles = ['customer', 'pharmacist', 'admin'];

    public array $roleRedirects = [
        'customer'   => '/customer/dashboard',
        'pharmacist' => '/pharmacist/dashboard',
        'admin'      => '/admin/dashboard',
    ];

    public array $roleLoginRoutes = [
        'customer'   => '/login',
        'pharmacist' => '/pharmacist/login',
        'admin'      => '/admin/login',
    ];
}
