<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\Tag\DefaultTags;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $enum = new \App\Models\Tag;
        foreach(DefaultTags::cases() as $tag) {
            Tag::create([
                'title' => $tag->name(),
                'color' => $tag
            ]);
        }
    }
}
