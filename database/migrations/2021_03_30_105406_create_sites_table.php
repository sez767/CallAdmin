<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url', 255);
            $table->boolean('is_active');
            $table->boolean('is_chat');
            $table->tinyInteger('answer_sec')->nullable();
            $table->string('widget_color', 10)->nullable();
            $table->tinyInteger('widget_size')->nullable();
            $table->string('location', 100)->nullable();
            $table->string('logo', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites');
    }
}
