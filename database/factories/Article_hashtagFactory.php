<?php

namespace Database\Factories;

use App\Models\Hashtag;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article_hashtag>
 */
class Article_hashtagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    public function definition(): array
    {
        $hashtag    = Hashtag::inRandomOrder()->first();
        $article            = Article::inRandomOrder()->first();

        return [
            //
            'article_id'   => $article->id,
            'hashtag_id'   => $hashtag->id,
        ];
    }
}
