<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSlidersAndCheckboxDependencies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->boolean('visible')->default(true);
        });

        Schema::table('checkboxes', function (Blueprint $table) {
            $table->boolean('slider_dependency_change')->default(false);
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
            $table->dropColumn('visible');
        });

        Schema::table('checkboxes', function (Blueprint $table) {
            $table->dropColumn('slider_dependency_change');
        });
    }
}
