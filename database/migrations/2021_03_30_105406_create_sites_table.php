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
            $table->id();
            $table->string('name', 255);
            $table->string('url', 255);
            $table->boolean('is_active')->default(0);
            $table->boolean('is_chat')->default(0);
            $table->boolean('is_answer')->default(0);
            $table->tinyInteger('answer_sec')->nullable();
            $table->string('answer_text')->nullable();
            $table->string('widget_color', 10)->nullable();
            $table->tinyInteger('widget_size')->nullable();
            $table->string('location', 100)->nullable();
            $table->integer('file_id')->nullable();
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
