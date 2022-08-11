<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Team;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
  /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Team::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'description'  => $this->faker->catchPhrase
        ];
    }
}
