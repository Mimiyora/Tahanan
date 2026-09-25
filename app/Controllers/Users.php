<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    public function index(): string
    {
        $userModel = new UserModel();
        $users = $userModel->orderBy('full_name', 'ASC')->findAll();

        foreach ($users as &$user) {
            $user['initials'] = $this->initials($user['full_name']);
        }
        unset($user);

        return view('users/index', [
            'title'       => 'User Accounts',
            'currentPage' => 'users',
            'users'       => $users,
        ]);
    }

    private function initials(string $fullName): string
    {
        $words = preg_split('/\s+/', trim($fullName)) ?: [];

        return strtoupper(implode('', array_map(
            static fn (string $word): string => substr($word, 0, 1),
            array_slice($words, 0, 2),
        )));
    }
}
