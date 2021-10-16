<?php

namespace Database\Factories;

use App\Models\Encounter;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EncounterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Encounter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create(),
            'name' => Str::title(
                $this->faker->unique()
                    ->words(rand(1, 5), true)
            ),
            'notes' => $this->faker->sentence(3),
        ];
    }
}
