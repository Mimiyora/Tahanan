<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('customers')->insertBatch([
            [
                'full_name' => 'Isabella Santos',
                'email' => 'isabella.santos@example.com',
                'phone' => '+63 917 234 0182',
                'created_at' => '2026-09-01 09:15:00',
            ],
            [
                'full_name' => 'Miguel Reyes',
                'email' => 'miguel.reyes@example.com',
                'phone' => '+63 905 682 4491',
                'created_at' => '2026-09-02 10:20:00',
            ],
            [
                'full_name' => 'Amara Villanueva',
                'email' => 'amara.v@example.com',
                'phone' => '+63 998 410 7635',
                'created_at' => '2026-09-03 11:05:00',
            ],
            [
                'full_name' => 'Rafael de Leon',
                'email' => 'rafael.deleon@example.com',
                'phone' => '+63 921 553 9076',
                'created_at' => '2026-09-04 14:30:00',
            ],
            [
                'full_name' => 'Sofia Mendoza',
                'email' => 'sofia.mendoza@example.com',
                'phone' => '+63 945 319 2280',
                'created_at' => '2026-09-05 16:10:00',
            ],
            [
                'full_name' => 'Gabriel Navarro',
                'email' => 'gabriel.n@example.com',
                'phone' => '+63 977 804 1159',
                'created_at' => '2026-09-06 08:45:00',
            ],
        ]);
    }
}
