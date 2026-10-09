<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPasswordToUsers extends Migration
{
    private const DEFAULT_PASSWORD = 'Tahanan123!';

    public function up(): void
    {
        if (! $this->db->tableExists('users') || $this->db->fieldExists('password', 'users')) {
            return;
        }

        $this->forge->addColumn('users', [
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
                'default'    => '',
                'after'      => 'avatar',
            ],
        ]);

        $this->db->table('users')
            ->where('password', '')
            ->update(['password' => password_hash(self::DEFAULT_PASSWORD, PASSWORD_DEFAULT)]);
    }

    public function down(): void
    {
        if ($this->db->tableExists('users') && $this->db->fieldExists('password', 'users')) {
            $this->forge->dropColumn('users', 'password');
        }
    }
}
