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

        $set_radcheck = Radcheck::find(1);
        $set_radcheck->hotel_id =1;
        $set_radcheck->router ='yes';
        $set_radcheck->save();

        $set_radcheck2 = Radcheck::find(2);
        $set_radcheck2->hotel_id =1;
        $set_radcheck2->router ='yes';
        $set_radcheck2->save();

    }
}
