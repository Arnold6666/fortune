<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Article::class;

    public function definition(): array
    {

        $randomUser = User::inRandomOrder()->first();
        return [
            'title'         => $this->faker->words(5, true),
            'name'          => $randomUser->name,
            'user_id'       => $randomUser->id,
            'content'       => $this->faker->paragraphs(3, true),
            'image'         => function () {
                $imagePath = glob(public_path('images/*'));
                $randomImagePath = $imagePath[array_rand($imagePath)];
                $data = file_get_contents($randomImagePath);
                $imageInfo = getimagesize($randomImagePath);
                $mimeType = $imageInfo['mime'];

                $imageData = base64_encode($data);
                $src = "data:{$mimeType};base64,{$imageData}";
                return $src;
            },
            'views'         => $this->faker->randomNumber(),
            'created_at'    => Carbon::now()->subDays(rand(1, 30)),
            'updated_at'    => Carbon::now(),
        ];
    }
}
