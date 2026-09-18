<?php

namespace App\Controllers;

class Users extends BaseController
{
    public function index(): string
    {
        // Temporary in-memory data source. This will be replaced by a model later.
        $users = [
            ['username' => 'ana.cruz', 'name' => 'Ana Cruz', 'role' => 'Manager', 'initials' => 'AC'],
            ['username' => 'paolo.lim', 'name' => 'Paolo Lim', 'role' => 'Head Barista', 'initials' => 'PL'],
            ['username' => 'mika.tan', 'name' => 'Mika Tan', 'role' => 'Cashier', 'initials' => 'MT'],
            ['username' => 'nico.garcia', 'name' => 'Nico Garcia', 'role' => 'Barista', 'initials' => 'NG'],
            ['username' => 'bea.ramos', 'name' => 'Bea Ramos', 'role' => 'Cashier', 'initials' => 'BR'],
            ['username' => 'luis.dizon', 'name' => 'Luis Dizon', 'role' => 'Inventory', 'initials' => 'LD'],
        ];

        return view('users/index', [
            'title'       => 'User Accounts',
            'currentPage' => 'users',
            'users'       => $users,
        ]);
    }
}
