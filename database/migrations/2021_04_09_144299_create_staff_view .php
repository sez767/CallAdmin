<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement($this->dropView());
    }

    private function createView(): string
    {

return <<<SQL

CREATE VIEW view_staff AS
    SELECT 
        staff.id AS accountId,
        staff.email AS accountName,
        staff.password AS accountPassword,
        staff.id AS extension
    FROM staff

SQL;
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    private function dropView(): string
    {
return <<<SQL
DROP VIEW IF EXISTS `view_staff`;
SQL;

    }
}