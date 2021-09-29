<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modifiers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->foreignId('creature_id');
            $table->string('creature_type');
            $table->boolean('ability')->default(0);
            $table->json('ability_dice')->nullable();
            $table->boolean('save')->default(0);
            $table->json('save_dice')->nullable();
            $table->boolean('attack')->default(0);
            $table->json('attack_dice')->nullable();
            $table->boolean('critical_range')->default(0);
            $table->integer('critical_range_start')->nullable();
            $table->boolean('damage')->default(0);
            $table->string('damage_as')->nullable();
            $table->integer('damage_dc')->nullable();
            $table->string('damage_save')->nullable();
            $table->json('damage_dice')->nullable();
            $table->boolean('enabled')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modifiers');
    }
}
