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
            $table->foreignId('creature_id');
            $table->string('creature_type');
            $table->string('type');
            $table->string('counter_type')->nullable();
            $table->integer('total')->nullable();
            $table->string('current')->nullable();
            $table->json('slots')->nullable();
            $table->string('recover')->nullable();
            $table->json('dice')->nullable();
            $table->integer('dice_table_id')->nullable();
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
