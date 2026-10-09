<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsArchivedToTasks extends Migration
{
    public function up(): void
    {
        if (! $this->db->tableExists('tasks') || $this->db->fieldExists('is_archived', 'tasks')) {
            return;
        }

        $this->forge->addColumn('tasks', [
            'is_archived' => [
                'type'       => 'BOOLEAN',
                'null'       => false,
                'default'    => false,
                'after'      => 'task_date',
            ],
        ]);
    }

    public function down(): void
    {
        if ($this->db->tableExists('tasks') && $this->db->fieldExists('is_archived', 'tasks')) {
            $this->forge->dropColumn('tasks', 'is_archived');
        }
    }
}
