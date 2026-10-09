<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('isLoggedIn') === true) {
            return null;
        }

        if (strtoupper($request->getMethod()) === 'GET') {
            $path = trim($request->getUri()->getPath(), '/');
            session()->set('redirectAfterLogin', $path === '' ? 'users' : $path);
        }

        return redirect()->to(site_url('login'))
            ->with('error', 'Please sign in to use this management action.');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
