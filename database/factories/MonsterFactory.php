<?php

namespace Database\Factories;

use App\Models\Monster;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

class MonsterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Monster::class;

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
            'hp_max' => $this->faker->numberBetween(1, 20),
            'hp_current' => $this->faker->numberBetween(1, 20),
            'hit_dice' => [],
            'ac' => $this->faker->numberBetween(1, 20),
            'ac_source' => 'leather armor',
            'initiative' => $this->faker->numberBetween(1, 20),
            'speed' => $this->faker->numberBetween(1, 20),
            'strength' => $this->faker->numberBetween(1, 20),
            'strength_mod' => $this->faker->numberBetween(1, 20),
            'strength_save' => $this->faker->numberBetween(1, 20),
            'athletics' => $this->faker->numberBetween(1, 20),
            'dexterity' => $this->faker->numberBetween(1, 20),
            'dexterity_mod' => $this->faker->numberBetween(1, 20),
            'dexterity_save' => $this->faker->numberBetween(1, 20),
            'acrobatics' => $this->faker->numberBetween(1, 20),
            'sleight_of_hand' => $this->faker->numberBetween(1, 20),
            'stealth' => $this->faker->numberBetween(1, 20),
            'constitution' => $this->faker->numberBetween(1, 20),
            'constitution_mod' => $this->faker->numberBetween(1, 20),
            'constitution_save' => $this->faker->numberBetween(1, 20),
            'intelligence' => $this->faker->numberBetween(1, 20),
            'intelligence_mod' => $this->faker->numberBetween(1, 20),
            'intelligence_save' => $this->faker->numberBetween(1, 20),
            'arcana' => $this->faker->numberBetween(1, 20),
            'history' => $this->faker->numberBetween(1, 20),
            'investigation' => $this->faker->numberBetween(1, 20),
            'nature' => $this->faker->numberBetween(1, 20),
            'religion' => $this->faker->numberBetween(1, 20),
            'wisdom' => $this->faker->numberBetween(1, 20),
            'wisdom_mod' => $this->faker->numberBetween(1, 20),
            'wisdom_save' => $this->faker->numberBetween(1, 20),
            'animal_handling' => $this->faker->numberBetween(1, 20),
            'insight' => $this->faker->numberBetween(1, 20),
            'medicine' => $this->faker->numberBetween(1, 20),
            'perception' => $this->faker->numberBetween(1, 20),
            'survival' => $this->faker->numberBetween(1, 20),
            'charisma' => $this->faker->numberBetween(1, 20),
            'charisma_mod' => $this->faker->numberBetween(1, 20),
            'charisma_save' => $this->faker->numberBetween(1, 20),
            'deception' => $this->faker->numberBetween(1, 20),
            'intimidation' => $this->faker->numberBetween(1, 20),
            'performance' => $this->faker->numberBetween(1, 20),
            'persuasion' => $this->faker->numberBetween(1, 20),
            'skills_auto_filled' => true,
            'spellcaster' => false,
            'notes' => $this->faker->sentence(4),
            'show_resources' => 1,
            'show_modifiers' => 1,
            'show_notes' => 1,
            'show_dice' => 0,

            'size'                  => 'medium',
            'type'                  => 'beast',
            'alignment'             => 'neutral',
            'damage_vulnerabilities' => '',
            'damage_resistances'    => '',
            'damage_immunities'     => '',
            'condition_immunities'  => '',
            'senses'                => 'passive Perception: 13',
            'languages'             => '',
            'challenge_rating'      => '1/2',
            'experience'            => '50',
            'source'                => '',
            'public'                => 1,
        ];
    }
}
