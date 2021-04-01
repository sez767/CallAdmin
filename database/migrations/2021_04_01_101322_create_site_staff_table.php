<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        if (!Schema::hasTable('site_staff')) {
            Schema::create('site_staff', function (Blueprint $table) {
                $table->id();
                $table->integer('site_id');
                $table->integer('staff_id');
                $table->foreign('site_id')->references('id')->on('sites');
                $table->foreign('staff_id')->references('id')->on('staff');
            });
        }    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_staff');
    }
}
