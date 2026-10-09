<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn') === true) {
            return redirect()->to(site_url('users'));
        }

        return view('auth/login', [
            'title'       => 'Staff Login',
            'currentPage' => 'login',
            'errors'      => session('errors') ?? [],
            'error'       => session('error'),
            'success'     => session('success'),
        ]);
    }

    public function attempt()
    {
        $credentials = [
            'username' => trim((string) $this->request->getPost('username')),
            'password' => (string) $this->request->getPost('password'),
        ];

        if (! $this->validateData($credentials, [
            'username' => ['label' => 'Username', 'rules' => 'required|max_length[50]'],
            'password' => ['label' => 'Password', 'rules' => 'required|max_length[255]'],
        ])) {
            return redirect()->to(site_url('login'))
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $user = (new UserModel())->where('username', $credentials['username'])->first();
        $hash = $user['password'] ?? '$2y$10$usesomesillystringfore7hnbRJHxXVLeakoG8K30oukPsA.ztMG';

        if ($user === null || ! password_verify($credentials['password'], $hash)) {
            return redirect()->to(site_url('login'))
                ->withInput()
                ->with('error', 'The username or password is incorrect.');
        }

        $session = session();
        $session->regenerate(true);
        $session->set([
            'isLoggedIn' => true,
            'userId'     => (int) $user['id'],
            'username'   => $user['username'],
            'fullName'   => $user['full_name'],
        ]);

        $destination = (string) ($session->get('redirectAfterLogin') ?? 'users');
        $session->remove('redirectAfterLogin');

        return redirect()->to(site_url(ltrim($destination, '/')))
            ->with('success', 'Welcome back, ' . $user['full_name'] . '.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(site_url('login'));
    }
}
