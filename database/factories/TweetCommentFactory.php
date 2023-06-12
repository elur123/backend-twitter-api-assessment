<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TweetComment>
 */
use App\Models\Tweet;
use App\Models\User;
class TweetCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tweet_id' => Tweet::factory(),
            'comment_by' => User::factory(),
            'comment' => fake()->sentence(5)
        ];
    }
}
