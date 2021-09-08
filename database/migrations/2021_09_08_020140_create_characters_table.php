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
            $table->integer('athletics')->default(0);
            $table->integer('dexterity')->default(0);
            $table->integer('dexterity_mod')->default(0);
            $table->integer('dexterity_save')->default(0);
            $table->integer('acrobatics')->default(0);
            $table->integer('sleight_of_hand')->default(0);
            $table->integer('stealth')->default(0);
            $table->integer('constitution')->default(0);
            $table->integer('constitution_mod')->default(0);
            $table->integer('constitution_save')->default(0);
            $table->integer('intelligence')->default(0);
            $table->integer('intelligence_mod')->default(0);
            $table->integer('intelligence_save')->default(0);
            $table->integer('arcana')->default(0);
            $table->integer('history')->default(0);
            $table->integer('investigation')->default(0);
            $table->integer('nature')->default(0);
            $table->integer('religion')->default(0);
            $table->integer('wisdom')->default(0);
            $table->integer('wisdom_mod')->default(0);
            $table->integer('wisdom_save')->default(0);
            $table->integer('animal_handling')->default(0);
            $table->integer('insight')->default(0);
            $table->integer('medicine')->default(0);
            $table->integer('perception')->default(0);
            $table->integer('survival')->default(0);
            $table->integer('charisma')->default(0);
            $table->integer('charisma_mod')->default(0);
            $table->integer('charisma_save')->default(0);
            $table->integer('deception')->default(0);
            $table->integer('intimidation')->default(0);
            $table->integer('performance')->default(0);
            $table->integer('persuasion')->default(0);
            $table->json('actions')->nullable();
            $table->json('modifiers')->nullable();
            $table->json('spells')->nullable();
            $table->json('resources')->nullable();
            $table->boolean('show_notepad')->default(true);
            $table->boolean('show_resources')->default(true);
            $table->boolean('show_spells')->default(true);
            $table->boolean('show_dice')->default(true);
            $table->text('notes')->nullable();;
            $table->json('skills')->nullable();
            $table->json('proficient_skills')->nullable();
            $table->json('expert_skills')->nullable();
            $table->json('special_skill_modifiers')->nullable();
            $table->string('race');
            $table->string('class');
            $table->integer('level')->default(0);
            $table->integer('current_hp')->default(0);
            $table->boolean('is_archived')->default(false);
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
