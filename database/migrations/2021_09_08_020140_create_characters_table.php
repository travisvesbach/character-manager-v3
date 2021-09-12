<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->bigInteger('user_id')->unsigned();
            $table->string('name');
            $table->integer('max_hp')->default(0);
            $table->json('hit_dice')->nullable();
            $table->integer('ac')->default(0);
            $table->string('ac_source')->nullable();
            $table->integer('initiative')->default(0);
            $table->string('speed');
            $table->integer('strength')->default(0);
            $table->integer('strength_mod')->default(0);
            $table->integer('strength_save')->default(0);
            $table->boolean('strength_save_proficiency')->default(0);
            $table->integer('athletics')->default(0);
            $table->boolean('athletics_proficiency')->default(0);
            $table->boolean('athletics_expertise')->default(0);
            $table->integer('dexterity')->default(0);
            $table->integer('dexterity_mod')->default(0);
            $table->integer('dexterity_save')->default(0);
            $table->boolean('dexterity_save_proficiency')->default(0);
            $table->integer('acrobatics')->default(0);
            $table->boolean('acrobatics_proficiency')->default(0);
            $table->boolean('acrobatics_expertise')->default(0);
            $table->integer('sleight_of_hand')->default(0);
            $table->boolean('sleight_of_hand_proficiency')->default(0);
            $table->boolean('sleight_of_hand_expertise')->default(0);
            $table->integer('stealth')->default(0);
            $table->boolean('stealth_proficiency')->default(0);
            $table->boolean('stealth_expertise')->default(0);
            $table->integer('constitution')->default(0);
            $table->integer('constitution_mod')->default(0);
            $table->integer('constitution_save')->default(0);
            $table->boolean('constitution_save_proficiency')->default(0);
            $table->integer('intelligence')->default(0);
            $table->integer('intelligence_mod')->default(0);
            $table->integer('intelligence_save')->default(0);
            $table->boolean('intelligence_save_proficiency')->default(0);
            $table->integer('arcana')->default(0);
            $table->boolean('arcana_proficiency')->default(0);
            $table->boolean('arcana_expertise')->default(0);
            $table->integer('history')->default(0);
            $table->boolean('history_proficiency')->default(0);
            $table->boolean('history_expertise')->default(0);
            $table->integer('investigation')->default(0);
            $table->boolean('investigation_proficiency')->default(0);
            $table->boolean('investigation_expertise')->default(0);
            $table->integer('nature')->default(0);
            $table->boolean('nature_proficiency')->default(0);
            $table->boolean('nature_expertise')->default(0);
            $table->integer('religion')->default(0);
            $table->boolean('religion_proficiency')->default(0);
            $table->boolean('religion_expertise')->default(0);
            $table->integer('wisdom')->default(0);
            $table->integer('wisdom_mod')->default(0);
            $table->integer('wisdom_save')->default(0);
            $table->boolean('wisdom_save_proficiency')->default(0);
            $table->integer('animal_handling')->default(0);
            $table->boolean('animal_handling_proficiency')->default(0);
            $table->boolean('animal_handling_expertise')->default(0);
            $table->integer('insight')->default(0);
            $table->boolean('insight_proficiency')->default(0);
            $table->boolean('insight_expertise')->default(0);
            $table->integer('medicine')->default(0);
            $table->boolean('medicine_proficiency')->default(0);
            $table->boolean('medicine_expertise')->default(0);
            $table->integer('perception')->default(0);
            $table->boolean('perception_proficiency')->default(0);
            $table->boolean('perception_expertise')->default(0);
            $table->integer('survival')->default(0);
            $table->boolean('survival_proficiency')->default(0);
            $table->boolean('survival_expertise')->default(0);
            $table->integer('charisma')->default(0);
            $table->integer('charisma_mod')->default(0);
            $table->integer('charisma_save')->default(0);
            $table->boolean('charisma_save_proficiency')->default(0);
            $table->integer('deception')->default(0);
            $table->boolean('deception_proficiency')->default(0);
            $table->boolean('deception_expertise')->default(0);
            $table->integer('intimidation')->default(0);
            $table->boolean('intimidation_proficiency')->default(0);
            $table->boolean('intimidation_expertise')->default(0);
            $table->integer('performance')->default(0);
            $table->boolean('performance_proficiency')->default(0);
            $table->boolean('performance_expertise')->default(0);
            $table->integer('persuasion')->default(0);
            $table->boolean('persuasion_proficiency')->default(0);
            $table->boolean('persuasion_expertise')->default(0);
            $table->json('actions')->nullable();
            $table->json('modifiers')->nullable();
            $table->json('spells')->nullable();
            $table->json('resources')->nullable();
            $table->boolean('show_notepad')->default(1);
            $table->boolean('show_resources')->default(1);
            $table->boolean('show_spells')->default(1);
            $table->text('notes')->nullable();
            $table->boolean('skills_auto_filled')->default(1);
            $table->string('race');
            $table->string('class');
            $table->integer('level')->default(0);
            $table->integer('current_hp')->default(0);
            $table->boolean('is_archived')->default(0);
            $table->date('archive_date')->nullable()->default(null);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characters');
    }
}
