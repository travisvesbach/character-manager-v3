<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

class ResourceFactory extends Factory
{
    use WithFaker;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Resource::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(1),
            'type' => 'counter',
            'counter_type' => 'slots',
            'total'     => $this->faker->numberBetween(1, 10),
            'recover'           => 'long',
        ];
    }
}
