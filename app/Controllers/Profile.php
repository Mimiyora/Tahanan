<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    public function index(): string
    {
        $user = (new UserModel())->first();

        if ($user === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'The demo profile has not been seeded yet.',
            );
        }

        return view('profile/index', [
            'title'       => 'Profile',
            'currentPage' => 'profile',
            'user'        => $user,
            'initials'    => $this->initials($user['full_name']),
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
