<?php

use Illuminate\Database\Seeder;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\Config::create(['key' => 'overhead', 'value' => '5']);

        factory(App\Config::class, 5)->create();
    }
}
