<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $helpers = ['url', 'form', 'medistore'];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    protected function isLoggedIn(): bool
    {
        return (bool) session()->get('is_logged_in');
    }

    protected function userId(): ?int
    {
        return session()->get('user_id');
    }

    protected function userRole(): ?string
    {
        return session()->get('user_role');
    }

    protected function requireLogin(string $redirect = '/login')
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to($redirect)->with('error', 'Please login to continue.');
        }
        return null;
    }

    protected function requireRole(array $roles, string $redirect = '/login')
    {
        if (!$this->isLoggedIn() || !in_array($this->userRole(), $roles, true)) {
            return redirect()->to($redirect)->with('error', 'Unauthorized access.');
        }
        return null;
    }

    protected function jsonResponse(array $data, int $status = 200)
    {
        return $this->response->setStatusCode($status)->setJSON($data);
    }
}
