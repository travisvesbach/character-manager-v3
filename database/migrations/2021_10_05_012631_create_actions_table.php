<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->foreignId('creature_id');
            $table->string('creature_type');
            $table->string('type');
            $table->string('range');
            $table->text('notes')->nullable();
            $table->boolean('attack')->default(0);
            $table->integer('attack_modifier')->nullable();
            $table->boolean('attack_does_damage')->default(0);
            $table->json('attack_dice')->nullable();
            $table->boolean('save')->default(0);
            $table->string('save_type')->nullable();
            $table->integer('save_dc')->nullable();
            $table->boolean('save_does_damage')->default(0);
            $table->json('save_dice')->nullable();
            $table->boolean('auto')->default(0);
            $table->boolean('auto_does_damage')->default(0);
            $table->json('auto_dice')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actions');
    }
}
