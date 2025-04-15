<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use League\CommonMark\Normalizer\SlugNormalizer;

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
        // id	category_id	title	excerpt	description	thumbnail	status	created_at	updated_at
        return [
            'title'=>fake()->title(),
            'category_id'=>Category::factory(),
            'excerpt'=>fake()->sentence(),
            'description'=>fake()->sentence(),
            'status'=>'Draft',
            'thumbnail'=>fake()->slug(),
        ];
    }
}
