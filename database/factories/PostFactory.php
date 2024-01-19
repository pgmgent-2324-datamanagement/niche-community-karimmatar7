<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create();
        return [
            'title' => fake()->sentence(),
            'description' => fake()->text(),
            'category_id' => $this->faker->randomElement(['1', '2', '3']),
            'game_id' => $this->faker->randomElement(['1', '2', '3']),
            'user_id' => $this->faker->randomElement(['1', '2', '3']),
            'image' => $faker->imageUrl(400, 300, 'people', true, 'Faker', true),
        ];
    }
}
