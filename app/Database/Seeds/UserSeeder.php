<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if ($this->db->table('users')->countAllResults() === 0) {
            $this->db->table('users')->insert([
                'username'   => 'gerard.doroja',
                'full_name'  => 'Gerard Doroja',
                'email'      => 'gerard.doroja@example.com',
                'avatar'     => null,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
