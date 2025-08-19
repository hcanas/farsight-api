<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'password' => 'password',
            'pin' => $this->faker->randomNumber(6, true),
        ];
    }
}
