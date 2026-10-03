<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('users')->emptyTable();
        $this->db->table('users')->insert([
            'username'   => 'gerard.doroja',
            'full_name'  => 'Gerard Doroja',
            'email'      => 'gerard.doroja@example.com',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
