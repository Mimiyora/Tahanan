<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table         = 'tasks';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'title',
        'status',
        'task_date',
        'is_archived',
        'created_at',
    ];

    public function forDate(string $date): array
    {
        return $this->where('task_date', $date)
            ->where('is_archived', 0)
            ->orderBy('created_at', 'ASC')
            ->findAll();
    }

    public function ordered(): self
    {
        return $this->where('is_archived', 0)
            ->orderBy('task_date', 'ASC')
            ->orderBy('created_at', 'ASC');
    }
}
