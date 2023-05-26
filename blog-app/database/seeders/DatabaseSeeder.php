<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Ranking;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        User::factory(6)
            ->create()
            ->each(function ($user, $index) {
                if ($index === 1 || $index === 2 || $index === 3) {
                    $posts = Post::factory(4)->create(['user_id' => $user->id]);
                }

                if ($index === 3 || $index === 4 || $index === 8) {
                    $comments = Comment::factory(4)->create(['user_id' => $user->id]);
                }

                $userScore = $user->posts()->sum('score') + $user->comments()->sum('score');
                $user->score = $userScore;
                $user->save();
            });

        // Remaining code for creating rankings
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
