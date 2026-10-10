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
            'success'     => session('success'),
        ]);
    }

    public function new(): string
    {
        return view('tasks/form', [
            'title'       => 'New Task',
            'currentPage' => 'tasks',
            'heading'     => 'Add to the day',
            'eyebrow'     => 'Keep the house ready',
            'action'      => site_url('tasks'),
            'submitLabel' => 'Save task',
            'task'        => null,
            'errors'      => session('errors') ?? [],
        ]);
    }

    public function create()
    {
        $data = $this->taskData();

        if (! $this->validateData($data, $this->taskRules())) {
            return redirect()->to(site_url('tasks/new'))
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['is_archived'] = 0;
        (new TaskModel())->insert($data);

        return redirect()->to(site_url('tasks'))->with('success', 'Added to the house schedule.');
    }

    public function edit(int $id): string
    {
        $task = $this->activeTask($id);

        return view('tasks/form', [
            'title'       => 'Edit Task',
            'currentPage' => 'tasks',
            'heading'     => 'Adjust the day',
            'eyebrow'     => 'Keep the house ready',
            'action'      => site_url('tasks/' . $id),
            'submitLabel' => 'Update task',
            'task'        => $task,
            'errors'      => session('errors') ?? [],
        ]);
    }

    public function update(int $id)
    {
        $this->activeTask($id);
        $data = $this->taskData();

        if (! $this->validateData($data, $this->taskRules())) {
            return redirect()->to(site_url('tasks/' . $id . '/edit'))
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        (new TaskModel())->update($id, $data);

        return redirect()->to(site_url('tasks'))->with('success', 'The house schedule is updated.');
    }

    public function delete(int $id)
    {
        $this->activeTask($id);
        (new TaskModel())->update($id, ['is_archived' => 1]);

        return redirect()->to(site_url('tasks'))->with('success', 'Removed from the house schedule.');
    }

    private function activeTask(int $id): array
    {
        $task = (new TaskModel())
            ->where('id', $id)
            ->where('is_archived', 0)
            ->first();

        if ($task === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Task not found.');
        }

        return $task;
    }

    private function taskData(): array
    {
        return [
            'title'     => trim((string) $this->request->getPost('title')),
            'status'    => trim((string) $this->request->getPost('status')),
            'task_date' => trim((string) $this->request->getPost('task_date')),
        ];
    }

    private function taskRules(): array
    {
        return [
            'title'     => ['label' => 'Task title', 'rules' => 'required|max_length[150]'],
            'status'    => ['label' => 'Status', 'rules' => 'required|in_list[pending,in_progress,completed]'],
            'task_date' => ['label' => 'Task date', 'rules' => 'required|valid_date[Y-m-d]'],
        ];
    }
}
