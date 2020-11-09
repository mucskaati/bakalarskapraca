<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkboxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('layout_id')->index();
            $table->string('title');
            $table->string('attribute_name');
            $table->timestamps();

            $table->foreign('layout_id')
                ->references('id')
                ->on('layouts')
                ->onDelete('cascade');
        });

        Schema::create('checkbox_slider', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checkbox_id')->index();
            $table->unsignedBigInteger('slider_id')->index();
            $table->text('value_function')->nullable();
            $table->timestamps();

            $table->foreign('checkbox_id')
                ->references('id')
                ->on('checkboxes')
                ->onDelete('cascade');

            $table->foreign('slider_id')
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
        Schema::dropIfExists('checkboxes');
        Schema::dropIfExists('checkbox_slider');
    }
}
