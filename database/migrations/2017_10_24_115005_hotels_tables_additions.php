<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HotelsTablesAdditions extends Migration
{
    /**
     * Add 2 necessary columns to hotels table
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotels', function (Blueprint $table) {
            //
            $table->string('main_url', 250)->after('timezone');
            $table->string('facebook_url', 250)->nullable()->after('main_url');;
        });
    }

    /**
     * Reverse.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotels', function (Blueprint $table) {
            //
            $table->dropColumn('main_url');
            $table->dropColumn('facebook_url');
        });
    }
}
