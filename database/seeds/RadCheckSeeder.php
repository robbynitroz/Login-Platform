<?php

use Illuminate\Database\Seeder;
use App\Radcheck;

class RadCheckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $set_radcheck = Radcheck::find(1);
        $set_radcheck->hotel_id =1;
        $set_radcheck->router ='yes';
        $set_radcheck->save();

    }
}
