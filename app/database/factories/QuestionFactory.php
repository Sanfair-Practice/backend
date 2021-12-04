<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'text' => $this->faker->text(),
            'answer' => $this->faker->word(),
            'dummy' => $this->createDummy(),
            'rules' => $this->faker->word(),
            'explanation' => $this->faker->word(),
        ];
    }

    private function createDummy(): array
    {
        return Collection::range(1, $this->faker->numberBetween(2, 4))
            ->map(fn () => $this->faker->word)
            ->toArray();
    }
}
