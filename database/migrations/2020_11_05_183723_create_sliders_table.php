<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('layout_id')->index();
            $table->string('title');
            $table->float('min');
            $table->float('max');
            $table->float('default')->nullable();
            $table->text('default_function')->nullable();
            $table->float('step');
            $table->timestamps();

            $table->foreign('layout_id')
                ->references('id')
                ->on('layouts')
                ->onDelete('cascade');
        });

        Schema::create('slider_dependencies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('slider_id')->index();
            $table->unsignedBigInteger('depended_slider_id')->index();
            $table->boolean('value_same_as_added')->default(true);
            $table->text('value_function')->nullable();
            $table->timestamps();

            $table->foreign('slider_id')
                ->references('id')
                ->on('sliders')
                ->onDelete('cascade');

            $table->foreign('depended_slider_id')
                ->references('id')
                ->on('sliders')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sliders');
        Schema::dropIfExists('slider_dependencies');
    }
}
