<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id, 
            'category_id' => Category::all()->random()->id, 
            'title' => $this->faker->realText(50), 
            'slug' => $this->faker->slug, 
            'description' => $this->faker->text(200),
            'content' => $this->faker->paragraphs(2,6), 
            'published' => true
        ];
    }
}
