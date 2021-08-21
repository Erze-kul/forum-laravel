<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => $this->faker->realText(30),
            'commentable_id' => mt_rand(1, 3),
            'commentable_type' => Topic::class,
            'user_id' => mt_rand(1, 15),
        ];
    }
}
