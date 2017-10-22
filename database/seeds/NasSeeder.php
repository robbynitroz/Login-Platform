<?php

use Illuminate\Database\Seeder;
use App\Nas;

class NasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $set_hotel = Nas::find(1);
        $set_hotel->hotel_id =1;
        $set_hotel->save();
    }
}
