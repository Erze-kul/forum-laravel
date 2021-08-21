<?php

namespace Database\Factories;

use App\Models\Topic;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factories\Factory;

class TopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Topic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create('ru_RU');

        return [
            'title' => $faker->sentence(5),
            'body' => $faker->realText(),
            'user_id' => mt_rand(1, 15),
        ];
    }
}
