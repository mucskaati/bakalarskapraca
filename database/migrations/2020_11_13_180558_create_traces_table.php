<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traces', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->unsignedBigInteger('graph_id')->index();
            $table->string('xaxis');
            $table->string('yaxis');
            $table->string('color')->nullable();
            $table->string('legendgroup')->nullable();
            $table->boolean('show_legend')->default(true);
            $table->timestamps();

            $table->foreign('graph_id')
                ->references('id')
                ->on('graphs')
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
        Schema::dropIfExists('traces');
    }
}
