<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuEntry>
 */
class MenuEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => fake()->word,
            'path' => '/'.fake()->word.'/'.fake()->word,
            'menu' => 'main',
            'order' => fake()->numberBetween(0, 5),
            'checksum' => md5(fake()->words(asText: true)),
            'type' => 'page',
        ];
    }
}
