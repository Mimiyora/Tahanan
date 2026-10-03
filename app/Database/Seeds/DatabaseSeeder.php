<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if ($this->db->table('tasks')->countAllResults() === 0) {
            $this->call('TaskSeeder');
        }

        if ($this->db->table('customers')->countAllResults() === 0) {
            $this->call('CustomerSeeder');
        }

        if ($this->db->table('staff_members')->countAllResults() === 0) {
            $this->call('StaffSeeder');
        }

        $this->call('UserSeeder');
    }
}
