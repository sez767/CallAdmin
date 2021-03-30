<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name_en');
                $table->string('name_ua');
                $table->string('name_ru');
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
            \App\Models\Category::create([
                'name_en' => 'auto accessories',
                'name_ua' => 'авто аксесуари',
                'name_ru' => 'авто аксессуари',
            ]);

            \App\Models\Category::create([
                'name_en' => 'auto tuning',
                'name_ua' => 'авто тюнинг',
                'name_ru' => 'авто тюнинг',
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
