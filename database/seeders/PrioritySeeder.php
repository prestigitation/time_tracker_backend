<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Priority;
enum PriorityColors : string {
    case NO_PRIORITY = 'gray';
    case LOW = 'green';
    case MEDIUM = '#e8ce68';
    case HIGH = 'red';
}
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
