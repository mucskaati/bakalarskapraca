<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class AddColumnsToMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->string('conversions_disk')->nullable();
            $table->string('uuid', 36)->nullable();
        });

        DB::statement('UPDATE media SET conversions_disk = disk');

        Media::cursor()->each(
            fn (Media $media) => $media->update(['uuid' => Str::uuid()])
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn('conversions_disk');
            $table->dropColumn('uuid', 36);
        });
    }
}
