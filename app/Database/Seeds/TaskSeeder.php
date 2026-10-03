<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use DateTimeImmutable;
use DateTimeZone;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $today = new DateTimeImmutable('today', new DateTimeZone(config('App')->appTimezone));

        $date = static fn (string $modifier): string => $today->modify($modifier)->format('Y-m-d');
        $created = static fn (string $modifier, string $time): string =>
            $today->modify($modifier)->format('Y-m-d') . ' ' . $time;

        $this->db->table('tasks')->insertBatch([
            [
                'title'      => 'Confirm completed requirements from yesterday',
                'status'     => 'completed',
                'task_date'  => $date('-2 days'),
                'created_at' => $created('-4 days', '09:00:00'),
            ],
            [
                'title'      => 'Organize project reference files',
                'status'     => 'completed',
                'task_date'  => $date('-1 day'),
                'created_at' => $created('-3 days', '10:15:00'),
            ],
            [
                'title'      => 'Review daily priorities',
                'status'     => 'completed',
                'task_date'  => $date('+0 days'),
                'created_at' => $created('-1 day', '16:30:00'),
            ],
            [
                'title'      => 'Prepare project stand-up notes',
                'status'     => 'in_progress',
                'task_date'  => $date('+0 days'),
                'created_at' => $created('-1 day', '16:45:00'),
            ],
            [
                'title'      => 'Validate the task dashboard',
                'status'     => 'pending',
                'task_date'  => $date('+0 days'),
                'created_at' => $created('-1 day', '17:00:00'),
            ],
            [
                'title'      => 'Submit the progress update',
                'status'     => 'pending',
                'task_date'  => $date('+0 days'),
                'created_at' => $created('-1 day', '17:15:00'),
            ],
            [
                'title'      => 'Plan tomorrow\'s development session',
                'status'     => 'pending',
                'task_date'  => $date('+1 day'),
                'created_at' => $created('+0 days', '08:00:00'),
            ],
            [
                'title'      => 'Check open review comments',
                'status'     => 'pending',
                'task_date'  => $date('+1 day'),
                'created_at' => $created('+0 days', '08:15:00'),
            ],
            [
                'title'      => 'Update the weekly task summary',
                'status'     => 'pending',
                'task_date'  => $date('+3 days'),
                'created_at' => $created('+0 days', '08:30:00'),
            ],
            [
                'title'      => 'Archive finished project notes',
                'status'     => 'pending',
                'task_date'  => $date('+7 days'),
                'created_at' => $created('+0 days', '08:45:00'),
            ],
        ]);
    }
}
