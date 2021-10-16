<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Monster;
use App\Models\Resource;
use App\Models\Modifier;
use App\Models\Action;

class MonsterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create the default monster
        $monster = Monster::factory()
            ->state([
            'user_id' => 1,
            'name' => 'Wolf',
            'hp_max' => 11,
            'hp_current' => 11,
            'hit_dice' => [
                [
                    "size" => 8,
                    "count" => 2,
                    "current" => 2
                ]
            ],
            'ac' => 13,
            'ac_source' => 'natural armor',
            'initiative' => 2,
            'speed' => '40 ft.',
            'strength' => 12,
            'strength_mod' => 1,
            'strength_save' => 1,
            'athletics' => 1,
            'dexterity' => 15,
            'dexterity_mod' => 2,
            'dexterity_save' => 2,
            'acrobatics' => 2,
            'sleight_of_hand' => 2,
            'stealth' => 4,
            'constitution' => 12,
            'constitution_mod' => 1,
            'constitution_save' => 1,
            'intelligence' => 3,
            'intelligence_mod' => -4,
            'intelligence_save' => -4,
            'arcana' => -4,
            'history' => -4,
            'investigation' => -4,
            'nature' => -4,
            'religion' => -4,
            'wisdom' => 12,
            'wisdom_mod' => 1,
            'wisdom_save' => 1,
            'animal_handling' => 1,
            'insight' => 1,
            'medicine' => 1,
            'perception' => 3,
            'survival' => 1,
            'charisma' => 6,
            'charisma_mod' => -2,
            'charisma_save' => -2,
            'deception' => -2,
            'intimidation' => -2,
            'performance' => -2,
            'persuasion' => -2,
            'skills_auto_filled' => 1,
            'spellcaster' => 0,
            'notes' => 'Keen Hearing and Smell: The wold has advantage on Wisdom (Perception) checks that rely on hearing or smell.

Pack Tactics: The wolf has advantage on an attack roll against a creature if at least one of the wolf\'s allies is within 5 feet of the creature and the ally isn\'t incapacitated.',
            'show_resources' => 0,
            'show_modifiers' => 0,
            'show_notes' => 1,
            'show_dice' => 0,
            'show_additional_stats' => 1,
            'size' => 'Medium',
            'type' => 'Beast',
            'alignment' => 'unaligned',
            'damage_vulnerabilities' => '',
            'damage_resistances' => '',
            'damage_immunities' => '',
            'condition_immunities' => '',
            'senses' => 'passive Perception: 13',
            'languages' => '',
            'challenge_rating' => '1/4',
            'experience' => '50',
            'source' => 'Monster Manual p341',
            'public' => 1,
            ])
            ->create();

            $monster->actions()->create([
                'name' => 'Bite',
                'type' => 'Action',
                'range' => '5 ft.',
                'attack' => 1,
                'attack_modifier' => 4,
                'attack_does_damage' => 1,
                'attack_dice' => [[
                    'size' => 4,
                    'count' => 2,
                    'modifier' => 2,
                    'type' => 'Piercing'
                ]],
                'notes' => 'If the target is a creature, it must succeed on a DC 11 Strength saving throw or be knocked prone.'
            ]);

        $this->command->info($monster->name . ' monster created....');
    }
}
