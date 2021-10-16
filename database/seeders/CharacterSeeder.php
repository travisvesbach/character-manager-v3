<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Character;
use App\Models\Resource;
use App\Models\Modifier;
use App\Models\Action;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create the default character
        $character = Character::factory()
            ->state([
            'user_id' => 1,
            'name' => 'Landrin',
            'hp_max' => 23,
            'hp_current' => 23,
            'hit_dice' => [
                [
                    "size" => 6,
                    "count" => 2,
                    "current" => 2
                ], [
                    "size" => 8,
                    "count" => 3,
                    "current" => 3
                ]
            ],
            'ac' => 13,
            'ac_source' => 'leather armor',
            'initiative' => 2,
            'speed' => '30 ft.',
            'strength' => 13,
            'strength_mod' => 1,
            'strength_save' => 1,
            'athletics' => 1,
            'dexterity' => 1,
            'dexterity_mod' => 1,
            'dexterity_save' => 1,
            'acrobatics' => 1,
            'sleight_of_hand' => 1,
            'stealth' => 1,
            'constitution' => 1,
            'constitution_mod' => 1,
            'constitution_save' => 1,
            'intelligence' => 1,
            'intelligence_mod' => 1,
            'intelligence_save' => 1,
            'arcana' => 1,
            'history' => 1,
            'investigation' => 1,
            'nature' => 1,
            'religion' => 1,
            'wisdom' => 1,
            'wisdom_mod' => 1,
            'wisdom_save' => 1,
            'animal_handling' => 1,
            'insight' => 1,
            'medicine' => 1,
            'perception' => 1,
            'survival' => 1,
            'charisma' => 1,
            'charisma_mod' => 1,
            'charisma_save' => 1,
            'deception' => 1,
            'intimidation' => 1,
            'performance' => 1,
            'persuasion' => 1,
            'skills_auto_filled' => 1,
            'spellcaster' => 1,
            'spell_type' => 'slots',
            'spell_dc' => 13,
            'spell_recover' => 'long',
            'spell_list_type' => 'known',
            'spell_slots_1' => [false, false, false, false],
            'spell_slots_2' => [false, false],
            'spell_list_0' => [
                "Firebolt",
                "Minor Illusion"
            ],
            'spell_list_1' => [
                "Bless",
                "Tasha's Hideous Laughter"
            ],
            'spell_list_2' => [
                "Silence",
            ],
            'notes' => 'here are some notes',
            'show_resources' => 1,
            'show_modifiers' => 1,
            'show_notes' => 1,
            'show_dice' => 1,
            'show_additional_stats' => 1,
            'race' => 'human',
            'class' => 'bard',
            'level' => 3,
            'is_archived' => 0,
            'languages' => 'Common',
            'senses' => 'darkvision: 60 ft., blindsight: 10 ft., passive Perception: 16',
            ])
            ->create();

            $character->resources()->create([
                'name' => 'Bardic Insp',
                'type' => 'counter',
                'counter_type' => 'slots',
                'total' => 3,
                'current' => 3,
                'slots' => [false, false, false],
                'recover' => 'long',
            ]);

            $character->modifiers()->create([
                'name' => 'Bless',
                'save' => 1,
                'save_dice' => [[
                    'size' => 4,
                    'count' => 1,
                    'modifier' => 0,
                ]],
                'attack' => 1,
                'attack_dice' => [[
                    'size' => 4,
                    'count' => 1,
                    'modifier' => 0,
                ]],
                'notes' => 'You are blessed',
            ]);

            $character->modifiers()->create([
                'name' => 'Sneak Attack',
                'damage' => 1,
                'damage_as' => 'attack',
                'damage_dice' => [[
                    'size' => 6,
                    'count' => 4,
                    'modifier' => 0,
                    'type' => 'Same as attack',
                ]],
            ]);

            $character->actions()->create([
                'name' => 'Dagger',
                'type' => 'Action',
                'range' => '5 ft.',
                'attack' => 1,
                'attack_modifier' => 5,
                'attack_does_damage' => 1,
                'attack_dice' => [[
                    'size' => 4,
                    'count' => 1,
                    'modifier' => 3,
                    'type' => 'Piercing'
                ]],
            ]);

            $character->actions()->create([
                'name' => 'Dissonant Whispers',
                'type' => 'Action',
                'range' => '30 ft.',
                'save' => 1,
                'save_dc' => 13,
                'save_type' => 'WIS',
                'save_does_damage' => 1,
                'save_dice' => [[
                    'size' => 6,
                    'count' => 3,
                    'modifier' => 0,
                    'type' => 'Psychic'
                ]],
            ]);

        $this->command->info($character->name . ' character created....');
    }
}
