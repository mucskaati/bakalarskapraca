<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSliderComparisonExperimentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slider_comparison_experiment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("slider_id")->index();
            $table->unsignedBigInteger("comparison_experiment_id")->index();
            $table->timestamps();

            $table->foreign('slider_id')
                ->references('id')
                ->on('sliders')
                ->onDelete('cascade');

            $table->foreign('comparison_experiment_id')
                ->references('id')
                ->on('comparison_experiments')
                ->onDelete('cascade');
        });

        Schema::create('checkbox_comparison_experiment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("checkbox_id")->index();
            $table->unsignedBigInteger("comparison_experiment_id")->index();
            $table->timestamps();

            $table->foreign('checkbox_id')
                ->references('id')
                ->on('checkboxes')
                ->onDelete('cascade');

            $table->foreign('comparison_experiment_id')
                ->references('id')
                ->on('comparison_experiments')
                ->onDelete('cascade');
        });

        Schema::table('sliders', function (Blueprint $table) {
            $table->dropForeign(['comparison_experiment_id']);
            $table->dropColumn('comparison_experiment_id');
        });

        Schema::table('checkboxes', function (Blueprint $table) {
            $table->dropForeign(['comparison_experiment_id']);
            $table->dropColumn('comparison_experiment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slider_comparison_experiment');

        Schema::table('sliders', function (Blueprint $table) {
            $table->unsignedBigInteger('comparison_experiment_id')->index()->nullable();
            $table->foreign('comparison_experiment_id')
                ->references('id')
                ->on('comparison_experiments')
                ->onDelete('cascade');
        });

        Schema::table('checkboxes', function (Blueprint $table) {
            $table->unsignedBigInteger('comparison_experiment_id')->index()->nullable();
            $table->foreign('comparison_experiment_id')
                ->references('id')
                ->on('comparison_experiments')
                ->onDelete('cascade');
        });
    }
}
