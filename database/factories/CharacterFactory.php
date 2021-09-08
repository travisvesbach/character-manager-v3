<?php

namespace Database\Factories;

use App\Models\Character;
use App\Models\User;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

class CharacterFactory extends Factory
{
    use WithFaker;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Character::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create(),
            'name' => $this->faker->sentence(4),
            'max_hp' => $this->faker->numberBetween(1, 20),
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
            'skills' => '',
            'proficient_skills' => [],
            'expert_skills' => [],
            'special_skill_modifiers' => [],
            'actions' => [],
            'modifiers' => [],
            'spells' => [],
            'resources' => [],
            'notes' => $this->faker->sentence(4),
            'show_notepad' => 0,
            'show_resources' => 0,
            'show_spells' => 0,
            'show_dice' => 0,
            'race' => 'Human',
            'class' => 'Wizard',
            'level' => $this->faker->numberBetween(1, 20),
            'current_hp' => $this->faker->numberBetween(1, 20),
            'is_archived' => false,
            'archive_date' => null,
        ];
    }
}
