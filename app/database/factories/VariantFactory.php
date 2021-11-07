<?php

namespace Database\Factories;

use App\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;

class VariantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Variant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'seed' => $this->faker->uuid(),
            'time' => $this->faker->numberBetween(10, 15),
            'errors' => $this->faker->numberBetween(-1, 10),
        ];
    }
}
