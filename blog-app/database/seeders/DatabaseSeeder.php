<?php

namespace Database\Seeders;
use App\Models\Ranking;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(1)->create();
        \App\Models\Post::factory(1)->create();
        \App\Models\Comment::factory(1)->create();

        $rankings = [
            ['name' => 'Rang 1', 'min_score' => 20],
            ['name' => 'Rang 2', 'min_score' => 40],
            ['name' => 'Rang 3', 'min_score' => 60],
            ['name' => 'Rang 4', 'min_score' => 80],
            ['name' => 'Rang 5', 'min_score' => 100],
        ];

        foreach ($rankings as $ranking) {
            Ranking::create($ranking);
        }
    }
}
