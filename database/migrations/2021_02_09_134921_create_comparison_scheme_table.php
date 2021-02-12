<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComparisonSchemeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comparison_scheme', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('experiment_id')->index();
            $table->unsignedBigInteger('scheme_id')->index();
            $table->timestamps();

            $table->foreign('experiment_id')
                ->references('id')
                ->on('experiments');

            $table->foreign('scheme_id')
                ->references('id')
                ->on('comparison_experiments');
        });

        Schema::table('experiments', function (Blueprint $table) {
            $table->string('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comparison_scheme');
        Schema::table('experiments', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
