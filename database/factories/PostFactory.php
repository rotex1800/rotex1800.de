<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
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

        $title = fake()->words(asText: true);
        $content = fake()->text;
        $publishedAt = fake()->dateTime;

        $checksum = md5($title . $content . $publishedAt->getTimestamp());
        return [
            'title' => $title,
            'content' => $content,
            'published_at' => $publishedAt,
            'checksum' => $checksum,
        ];
    }
}
