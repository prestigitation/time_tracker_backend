<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Priority;
use App\Models\PriorityColors;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $priorities = [
            [
                'title' => 'Нет приоритета',
                'color' => PriorityColors::NO_PRIORITY
            ],
            [
                'title' => 'Низкий',
                'color' => PriorityColors::LOW
            ],
            [
                'title' => 'Средний',
                'color' => PriorityColors::MEDIUM
            ],
            [
                'title' => 'Высокий',
                'color' => PriorityColors::HIGH,
            ]
        ];

        foreach ($priorities as $priority)
        {
            Priority::create([
                'title' => $priority['title'],
                'color' => $priority['color']
            ]);
        }
    }
}
