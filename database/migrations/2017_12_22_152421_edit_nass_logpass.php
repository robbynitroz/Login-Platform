<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditNassLogpass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nas', function (Blueprint $table) {
            $table->string('mikrotik_username', 254)->change();
            $table->string('mikrotik_password', 254)->change();
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
            $table->string('mikrotik_username', 128)->change();
            $table->string('mikrotik_password', 128)->change();
        });
    }
}
