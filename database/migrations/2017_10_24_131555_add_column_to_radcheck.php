<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToRadcheck extends Migration
{
    /**
     * Hotel ad signed to MAC address.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('radcheck', function (Blueprint $table) {
            //
            $table->integer('hotel_id')->unsigned()->nullable();
            $table->char('router', 3)->default('no');
            $table->foreign('hotel_id')->references('id')->on('hotels');
        });
    }

    /**
     * Reverse.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('radcheck', function (Blueprint $table) {
            //
            $table->dropForeign(['hotel_id']);
            Schema::dropIfExists('hotel_id');
            Schema::dropIfExists('router');
        });
    }
}
