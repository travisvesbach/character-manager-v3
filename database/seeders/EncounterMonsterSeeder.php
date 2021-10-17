<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EncounterMonster;
use App\Models\Monster;
use App\Models\Encounter;

class EncounterMonsterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $monster = Monster::find(1);

        $encounter_monster = $monster->replicate()->setTable('encounter_monsters');
        unset($encounter_monster->public);
        $encounter_monster->user_id = 1;
        $encounter_monster->encounter_id = 1;
        $encounter_monster->weight = 1;
        $encounter_monster->save();

        $relationships = ['modifiers', 'resources', 'actions'];

        foreach($relationships as $relationship) {
            foreach($monster->{$relationship} as $item) {
                $new_item = $item->replicate();
                $new_item->creature_id = $encounter_monster->id;
                $new_item->creature_type = 'App\Models\EncounterMonster';
                $new_item->save();
            }
        }

        $this->command->info($encounter_monster->name . ' encounter monster created....');
    }
}
