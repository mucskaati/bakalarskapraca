<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examples', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('experiment_id')->index();
            $table->string('title');
            $table->timestamps();

            $table->foreign('experiment_id')
                ->references('id')
                ->on('experiments')
                ->onDelete('cascade');
        });

        Schema::create('example_slider', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('example_id')->index();
            $table->unsignedBigInteger('slider_id')->index();
            $table->string('value');
            $table->timestamps();

            $table->foreign('example_id')
                ->references('id')
                ->on('examples')
                ->onDelete('cascade');

            $table->foreign('slider_id')
                ->references('id')
                ->on('sliders')
                ->onDelete('cascade');
        });

        Schema::create('example_checkbox', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('example_id')->index();
            $table->unsignedBigInteger('checkbox_id')->index();
            $table->timestamps();

            $table->foreign('example_id')
                ->references('id')
                ->on('examples')
                ->onDelete('cascade');

            $table->foreign('checkbox_id')
                ->references('id')
                ->on('checkboxes')
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
        Schema::table('examples', function (Blueprint $table) {
            $table->dropForeign(['experiment_id']);
        });
        Schema::table('example_slider', function (Blueprint $table) {
            $table->dropForeign(['example_id']);
            $table->dropForeign(['slider_id']);
        });

        Schema::table('example_checkbox', function (Blueprint $table) {
            $table->dropForeign(['example_id']);
            $table->dropForeign(['checkbox_id']);
        });

        Schema::dropIfExists('examples');
        Schema::dropIfExists('example_slider');
        Schema::dropIfExists('example_checkbox');
    }
}
