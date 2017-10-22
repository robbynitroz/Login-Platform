<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NasTableChanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nas', function (Blueprint $table) {
            //
            $table->integer('hotel_id')->unsigned()->change();
            $table->foreign('hotel_id')->references('id')->on('hotels');
            $table->string('mikrotik_username', 128);
            $table->string('mikrotik_password', 128);
            $table->timestamps();
            $table->softDeletes();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nas', function (Blueprint $table) {
            //
            $table->dropForeign(['hotel_id']);
        });
    }
}
