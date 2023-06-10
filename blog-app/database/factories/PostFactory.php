<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory {
    protected $model = Post::class;

    public function definition() {
        return [
            'title' => $this->faker->sentence(5),
            'content' => $this->faker->paragraphs(3, true),
            'tags' => implode(', ', $this->faker->words(3)),
            'score' => 8,
            "photo" => "example.png",
            'date' => $this->faker->date(),
            'user_id' => User::factory(),
        ];
    }
}
