<?php

namespace Database\Seeders;

use App\Http\Repository\TaskRepository;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tasks = [[
            'priority_id' => 1,
            'title' => 'test task',
            'description' => 'test task description',
            'files' => '[]',
            'subtasks' => '[]',
            'ended_at' => Carbon::now()->addDays(3)->toDateTimeString(),
        ]];
        foreach ($tasks as $task)
        {
            Task::create([
                'description' => $task['description'],
                'title' => $task['title'],
                'ended_at' => $task['ended_at'],
                'subtasks' => $task['subtasks'],
                'files' => $task['files'],
                'priority_id' => $task['priority_id']
            ]);
        }
    }
}
