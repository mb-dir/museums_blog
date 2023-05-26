<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory {
    protected $model = User::class;

    public function definition(){
        $lastName = strtolower($this->faker->lastName);
        $domain = 'gmail.com';
        $uniqueFakeEmail = "{$lastName}@{$domain}";

        return [
            'name' => $lastName,
            'email' => $uniqueFakeEmail,
            'password' => bcrypt('password'),
            'score' => $this->faker->numberBetween(0, 10),
            'register_date' => now(),
        ];
    }
}
