<?php

namespace App\Controllers;

class Customers extends BaseController
{
    public function index(): string
    {
        // Temporary in-memory data source. This will be replaced by a model later.
        $customers = [
            ['name' => 'Isabella Santos', 'email' => 'isabella.santos@example.com', 'phone' => '+63 917 234 0182', 'initials' => 'IS'],
            ['name' => 'Miguel Reyes', 'email' => 'miguel.reyes@example.com', 'phone' => '+63 905 682 4491', 'initials' => 'MR'],
            ['name' => 'Amara Villanueva', 'email' => 'amara.v@example.com', 'phone' => '+63 998 410 7635', 'initials' => 'AV'],
            ['name' => 'Rafael de Leon', 'email' => 'rafael.deleon@example.com', 'phone' => '+63 921 553 9076', 'initials' => 'RL'],
            ['name' => 'Sofia Mendoza', 'email' => 'sofia.mendoza@example.com', 'phone' => '+63 945 319 2280', 'initials' => 'SM'],
            ['name' => 'Gabriel Navarro', 'email' => 'gabriel.n@example.com', 'phone' => '+63 977 804 1159', 'initials' => 'GN'],
        ];

        return view('customers/index', [
            'title'       => 'Customer Accounts',
            'currentPage' => 'customers',
            'customers'   => $customers,
        ]);
    }
}
