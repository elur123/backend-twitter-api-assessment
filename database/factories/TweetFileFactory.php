<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TweetFile>
 */
use App\Models\Tweet;
class TweetFileFactory extends Factory
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
            'file_name' => 'test.png',
            'file_url' => 'storage/tweet/1/test.png'
        ];
    }
}
