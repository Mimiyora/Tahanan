<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

final class AddAvatarPublicIdToUsers extends Migration
{
    public function up(): void
    {
        if ($this->db->tableExists('users') && ! $this->db->fieldExists('avatar_public_id', 'users')) {
            $this->forge->addColumn('users', [
                'avatar_public_id' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'avatar',
                ],
            ]);
        }
    }

    public function down(): void
    {
        if ($this->db->tableExists('users') && $this->db->fieldExists('avatar_public_id', 'users')) {
            $this->forge->dropColumn('users', 'avatar_public_id');
        }
    }
}
