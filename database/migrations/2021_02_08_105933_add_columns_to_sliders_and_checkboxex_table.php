<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSlidersAndCheckboxexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->unsignedBigInteger('layout_id')->nullable()->change();
            $table->unsignedBigInteger('comparison_experiment_id')->index()->nullable();
            $table->string('type');

            $table->foreign('comparison_experiment_id')
                ->references('id')
                ->on('comparison_experiments')
                ->onDelete('cascade');
        });

        Schema::table('checkboxes', function (Blueprint $table) {
            $table->unsignedBigInteger('layout_id')->nullable()->change();
            $table->unsignedBigInteger('comparison_experiment_id')->index()->nullable();
            $table->string('type');

            $table->foreign('comparison_experiment_id')
                ->references('id')
                ->on('comparison_experiments')
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
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropForeign(['comparison_experiment_id']);
            $table->dropColumn('comparison_experiment_id');
            $table->dropColumn('type');
        });

        Schema::table('checkboxes', function (Blueprint $table) {
            $table->dropForeign(['comparison_experiment_id']);
            $table->dropColumn('comparison_experiment_id');
            $table->dropColumn('type');
        });
    }
}
