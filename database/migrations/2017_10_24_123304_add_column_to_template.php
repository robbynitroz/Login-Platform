<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToTemplate extends Migration
{
    /**
     * Add type column to template.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('templates', function (Blueprint $table) {
            //
            $table->string('type', 20)->after('activated');
        });
    }

    /**
     * Reverse.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('templates', function (Blueprint $table) {
            //
            $table->dropColumn('type');
        });
    }
}
