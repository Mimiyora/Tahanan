<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('users')->insertBatch([
            ['username' => 'ana.cruz', 'full_name' => 'Ana Cruz', 'created_at' => '2026-09-01 08:00:00'],
            ['username' => 'paolo.lim', 'full_name' => 'Paolo Lim', 'created_at' => '2026-09-01 08:05:00'],
            ['username' => 'mika.tan', 'full_name' => 'Mika Tan', 'created_at' => '2026-09-01 08:10:00'],
            ['username' => 'nico.garcia', 'full_name' => 'Nico Garcia', 'created_at' => '2026-09-01 08:15:00'],
            ['username' => 'bea.ramos', 'full_name' => 'Bea Ramos', 'created_at' => '2026-09-01 08:20:00'],
            ['username' => 'luis.dizon', 'full_name' => 'Luis Dizon', 'created_at' => '2026-09-01 08:25:00'],
        ]);
    }
}
