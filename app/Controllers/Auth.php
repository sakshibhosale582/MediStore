<?php

namespace App\Controllers;

use App\Models\UserModel;
use Config\Auth as AuthConfig;

class Auth extends BaseController
{
    public function login(): string
    {
        return view('auth/login', ['pageTitle' => 'Login | MediStore']);
    }

    public function register(): string
    {
        return view('auth/register', ['pageTitle' => 'Register | MediStore']);
    }

    public function attemptLogin()
    {
        $email = trim($this->request->getPost('email') ?? '');
        $password = $this->request->getPost('password') ?? '';

        if ($email === '' || $password === '') {
            return redirect()->back()->withInput()->with('error', 'Email and password are required.');
        }

        $userModel = model(UserModel::class);
        $user = $userModel->findByEmail($email);

        if (! $user || ! $userModel->verifyPassword($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
        }

        if (empty($user['is_active'])) {
            return redirect()->back()->withInput()->with('error', 'Your account is inactive.');
        }

        session()->set([
            'is_logged_in' => true,
            'user_id'      => (int) $user['id'],
            'user_name'    => $user['name'],
            'user_role'    => $user['role'],
        ]);

        $authConfig = config(AuthConfig::class);
        $target = $authConfig->roleRedirects[$user['role']] ?? '/';

        return redirect()->to($target)->with('success', 'Welcome back!');
    }

    public function attemptRegister()
    {
        $userModel = model(UserModel::class);

        $data = [
            'name'     => trim($this->request->getPost('name') ?? ''),
            'email'    => trim($this->request->getPost('email') ?? ''),
            'phone'    => trim($this->request->getPost('phone') ?? ''),
            'password' => $this->request->getPost('password') ?? '',
            'role'     => 'customer',
            'is_active' => 1,
            'email_verified' => 1,
        ];

        if ($data['name'] === '' || $data['email'] === '' || $data['password'] === '') {
            return redirect()->back()->withInput()->with('error', 'Please complete all required fields.');
        }

        if (strlen($data['password']) < 6) {
            return redirect()->back()->withInput()->with('error', 'Password must be at least 6 characters.');
        }

        $user = $userModel->findByEmail($data['email']);
        if ($user) {
            return redirect()->back()->withInput()->with('error', 'An account with this email already exists.');
        }

        if (! $userModel->insert($data)) {
            return redirect()->back()->withInput()->with('error', 'Unable to create account right now.');
        }

        return redirect()->to('/login')->with('success', 'Account created successfully. Please log in.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/')->with('success', 'You have been logged out.');
    }
}
