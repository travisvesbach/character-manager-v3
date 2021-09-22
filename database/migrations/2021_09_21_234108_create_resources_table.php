<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->integer('creature_id');
            $table->string('creature_type');
            $table->string('type');
            $table->integer('counter_total')->nullable();
            $table->string('counter_type')->nullable();
            $table->json('counter_slots')->nullable();
            $table->string('counter_current')->nullable();
            $table->string('recover')->nullable();
            $table->integer('dice_count')->nullable();
            $table->integer('dice_size')->nullable();
            $table->integer('dice_modifier')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resources');
    }
}
