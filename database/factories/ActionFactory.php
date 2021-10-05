<?php

namespace Database\Factories;

use App\Models\Action;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Action::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'                  => 'shortsword',
            'type'                  => 'action',
            'range'                 => '5 ft.',
            'notes'                 => null,
            'attack'                => true,
            'attack_modifier'       => 5,
            'attack_does_damage'    => true,
            'attack_dice'           => [[
                "size" => "6",
                "count" => "1",
                "modifier" => 3,
                "type" => 'Piercing'
            ]],
            'save'                  => false,
            'save_type'             => null,
            'save_dc'               => null,
            'save_does_damage'      => false,
            'save_dice'             => null,
            'auto'                  => false,
            'auto_does_damage'      => false,
            'auto_dice'             => null,
        ];
    }
}
