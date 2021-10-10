<?php

namespace Database\Factories;

use App\Models\Modifier;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModifierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Modifier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Bless',
            'ability' => true,
            'ability_dice' => [[
                "size" => "4",
                "count" => "1",
                "modifier" => null
            ]],
            'save' => true,
            'save_dice' => [[
                "size" => "4",
                "count" => "1",
                "modifier" => null
            ]],
            'attack' => true,
            'attack_dice' => [[
                "size" => "4",
                "count" => "1",
                "modifier" => null
            ]],
            'critical_range' => false,
            'critical_range_start' => null,
            'damage' => false,
            'damage_as' => null,
            'damage_dc' => null,
            'damage_save' => null,
            'damage_dice' => null,
            'notes' => null,
        ];
    }
}
