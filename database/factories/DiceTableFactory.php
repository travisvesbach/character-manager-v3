<?php

namespace Database\Factories;

use App\Models\DiceTable;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class DiceTableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DiceTable::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create(),
            'name' => $this->faker->name(),
            'rows' => [
                [
                    'range' => [1],
                    'result' => 'The result was 1'
                ],
                [
                    'range' => [2],
                    'result' => 'The result was 2'
                ],
                [
                    'range' => [3],
                    'result' => 'The result was 3'
                ],
                [
                    'range' => [4],
                    'result' => 'The result was 4'
                ],
                [
                    'range' => [5],
                    'result' => 'The result was 5'
                ],
                [
                    'range' => [6],
                    'result' => 'The result was 6'
                ],
            ],
            'public' => 1,
        ];
    }
}
