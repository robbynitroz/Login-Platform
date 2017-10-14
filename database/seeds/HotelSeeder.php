<?php

use Illuminate\Database\Seeder;
use App\Hotel;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds, adding critical data to hotels table
     *
     * @return void
     */
    public function run()
    {
        //
        Hotel::create(
            [
                'name' => 'GuestCompass',
                'session_timeout' => '1d'
            ]
        );
    }
}
