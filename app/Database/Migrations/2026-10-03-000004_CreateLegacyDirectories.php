<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLegacyDirectories extends Migration
{
    public function up(): void
    {
        if (! $this->db->tableExists('customers')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'auto_increment' => true,
                ],
                'full_name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ],
                'email' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ],
                'phone' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'null'       => true,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('customers');
        }

        if (! $this->db->tableExists('staff_members')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'auto_increment' => true,
                ],
                'username' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                ],
                'full_name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addUniqueKey('username');
            $this->forge->createTable('staff_members');
        }
    }

    public function down(): void
    {
        $this->forge->dropTable('staff_members', true);
        $this->forge->dropTable('customers', true);
    }
}
