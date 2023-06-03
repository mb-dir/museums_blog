<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Ranking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
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

        $users = User::factory(10)->create();

        $userData = [
            1 => ['posts' => 1],
            2 => ['posts' => 4],
            3 => ['posts' => 6, 'comments' => 4],
            4 => ['comments' => 1],
        ];

        foreach ($users as $index => $user) {
            if (isset($userData[$index])) {
                if (isset($userData[$index]['posts'])) {
                    Post::factory($userData[$index]['posts'])->create(['user_id' => $user->id]);
                }

                if (isset($userData[$index]['comments'])) {
                    Comment::factory($userData[$index]['comments'])->create(['user_id' => $user->id]);
                }
            }

            $userScore = $user->posts()->sum('score') + $user->comments()->sum('score');
            $user->score = $userScore;

            $rankingIndexes = [1, 2, 3, 4, 5];
            foreach ($rankingIndexes as $rank) {
                if ($user->score >= $rank * 20) {
                    $user->rankings()->syncWithoutDetaching([$rank]);
                }
            }

            $user->save();
        }

        // Create admin
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'register_date' => now(),
            'score' => 0,
            'role' => 'admin',
        ]);
    }
}
