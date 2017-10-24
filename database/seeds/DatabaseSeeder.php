<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(HotelSeeder::class);
         $this->call(TemplateSeeder::class);
         $this->call(NasSeeder::class);
         $this->call(RadCheckSeeder::class);
    }
}
