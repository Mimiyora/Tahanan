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
                'password'   => password_hash('Tahanan123!', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $users = $this->db->table('users')->select('id, password')->get()->getResultArray();

        foreach ($users as $user) {
            if (empty($user['password'])) {
                $this->db->table('users')
                    ->where('id', $user['id'])
                    ->update(['password' => password_hash('Tahanan123!', PASSWORD_DEFAULT)]);
            }
        }
    }
}
