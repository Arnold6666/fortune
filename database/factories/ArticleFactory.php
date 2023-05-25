<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

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

        $imagePath = $this->faker->image(storage_path('app/public/articles'), 800, 600, null, false);
        // die($imagePath);
        $imageFile = new File(storage_path('app/public/articles/' . $imagePath));

        $imageFilename = $imageFile->getFilename();
        $imageStoragePath = '/storage/articles/' . $imageFilename;
        Storage::disk('public')->put($imageStoragePath, file_get_contents(storage_path('app/public/articles/' . $imagePath)));

        return [
            'title'         => $this->faker->words(5, true),
            'name'          => $randomUser->name,
            'user_id'       => $randomUser->id,
            'content'       => $this->faker->paragraphs(3, true),
            'image_path'    => $imageStoragePath,
            'image_filename'=> $imageFilename,
            'views'         => $this->faker->randomNumber(),
            'created_at'    => Carbon::now()->subDays(rand(1, 30)),
            'updated_at'    => Carbon::now(),
        ];
    }
}
