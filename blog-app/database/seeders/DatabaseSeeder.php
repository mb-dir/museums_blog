<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Ranking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
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
        User::factory(6)
            ->create()
            ->each(function ($user, $index) {
                if ($index === 1 || $index === 2 || $index === 3) {
                    Post::factory(4)->create(['user_id' => $user->id]);
                }

                if ($index === 3 || $index === 4 || $index === 8) {
                    Comment::factory(4)->create(['user_id' => $user->id]);
                }

                $userScore = $user->posts()->sum('score') + $user->comments()->sum('score');
                $user->score = $userScore;

                $ranking_indexes = [1, 2, 3, 4, 5];
                foreach($ranking_indexes as $rank){
                    if($user->score >= $rank * 20){
                        $user->rankings()->syncWithoutDetaching([$rank]);
                    }
                }

                $user->save();
        });
        // create admin
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'register_date' => now(),
            'score' => 0,
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
