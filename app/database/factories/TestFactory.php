<?php

namespace Database\Factories;

use App\Enums\Test\Type;
use App\Models\Test;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class TestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Test::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity' => $this->faker->numberBetween(1, 25),
            'errors' => $this->faker->numberBetween(-1, 100),
            'time' => $this->faker->numberBetween(10, 15),
            'type' => Arr::random([Type::TRAINING, Type::TEST, Type::EXAM]),
        ];
    }
}
