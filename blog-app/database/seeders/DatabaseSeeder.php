<?php

namespace Database\Seeders;
use App\Models\Ranking;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        \App\Models\User::factory(1)->create();
        \App\Models\Post::factory(1)->create();
        \App\Models\Comment::factory(1)->create();

        $rankings = [
            ['name' => 'Nowicjusz Muzealny', 'min_score' => 20],
            ['name' => 'Odkrywca Kultury', 'min_score' => 40],
            ['name' => 'Ekspert Artystyczny', 'min_score' => 60],
            ['name' => 'Wielki Kustosz', 'min_score' => 80],
            ['name' => 'Arcymistrz Muzealnictwa', 'min_score' => 100],
        ];

        foreach ($rankings as $ranking) {
            Ranking::create($ranking);
        }
    }
}
