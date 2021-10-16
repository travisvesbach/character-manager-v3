<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Encounter;

class EncounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $encounter = Encounter::factory()
            ->state([
                'user_id' => 1,
            ])
            ->create();

        $this->command->info($encounter->name . ' encounter created....');
    }
}
