<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usgs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->datetime('event_at');
            $table->datetime('record_updated_at');
            $table->string('usgs_id')->unique()->index();
            $table->string('uuid', 36)->unique()->index();
            $table->string('place');
            $table->double('latitude', 7, 4);
            $table->double('longitude', 7, 4);
            $table->double('magnitude', 3, 1);
            $table->double('depth', 5, 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('usgs');
    }
}
