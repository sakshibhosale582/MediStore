<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/login')->with('error', 'Please login to continue.');
        }

        if ($arguments) {
            $role = session()->get('user_role');
            if (!in_array($role, $arguments, true)) {
                $redirects = [
                    'customer'   => '/customer/dashboard',
                    'pharmacist' => '/pharmacist/dashboard',
                    'admin'      => '/admin/dashboard',
                ];
                return redirect()->to($redirects[$role] ?? '/')->with('error', 'Unauthorized access.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
