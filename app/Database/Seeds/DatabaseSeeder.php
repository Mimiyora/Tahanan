<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if ($this->db->table('customers')->countAllResults() === 0) {
            $this->call('CustomerSeeder');
        }

        if ($this->db->table('users')->countAllResults() === 0) {
            $this->call('UserSeeder');
        }
    }
}
