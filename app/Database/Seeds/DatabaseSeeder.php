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

        $this->call('UserSeeder');
    }
}
