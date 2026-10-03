<?php

namespace App\Controllers;

use App\Models\TaskModel;

class Tasks extends BaseController
{
    public function index(): string
    {
        $tasks = (new TaskModel())->ordered()->findAll();

        return view('tasks/index', [
            'title'       => 'All Tasks',
            'currentPage' => 'tasks',
            'tasks'       => $tasks,
        ]);
    }
}
