<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientAuthsTable extends Migration
{
    /**
     * Create client_auths table.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_auths', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id')->unsigned()->nullable();
            $table->string('method', 20);
            $table->foreign('hotel_id')->references('id')->on('hotels');
            $table->timestamps();
        });
    }

    /**
     * Delete client_auths table.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_auths');
    }
}
