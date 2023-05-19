<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Carbon;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomUser = User::inRandomOrder()->first();
        $randomArticle = Article::inRandomOrder()->first();
        return [
            'user_id'       => $randomUser->id,
            'name'          => $randomUser->name,
            'article_id'    => $randomArticle->id,
            'comment'       => $this->faker->words(10, true),
            'created_at'    => Carbon::now()->subDays(rand(1, 30)),
            'updated_at'    => Carbon::now(),
        ];
    }
}
