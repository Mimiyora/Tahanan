<?php

namespace App\Controllers;

use App\Models\TaskModel;
use DateTimeImmutable;
use DateTimeZone;

class Pages extends BaseController
{
    public function home(): string
    {
        $today = (new DateTimeImmutable('now', new DateTimeZone(config('App')->appTimezone)))
            ->format('Y-m-d');
        $tasks = (new TaskModel())->forDate($today);

        return view('pages/home', [
            'title'       => 'Today',
            'currentPage' => 'home',
            'today'       => $today,
            'tasks'       => $tasks,
            'completed'   => count(array_filter(
                $tasks,
                static fn (array $task): bool => $task['status'] === 'completed',
            )),
        ]);
    }

    public function about(): string
    {
        return view('pages/about', [
            'title'       => 'About',
            'currentPage' => 'about',
        ]);
    }

    public function coffeehouse(): string
    {
        return view('pages/coffeehouse', [
            'title'       => 'Coffeehouse Home',
            'currentPage' => 'coffeehouse',
        ]);
    }

    public function coffeehouseAbout(): string
    {
        return view('pages/coffeehouse_about', [
            'title'       => 'Our Story',
            'currentPage' => 'coffeehouse-about',
        ]);
    }
}
