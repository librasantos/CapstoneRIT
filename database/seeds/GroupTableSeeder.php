<?php

use Illuminate\Database\Seeder;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounting = new \App\Group(['name' => 'Accounting']);
        $accounting->save();

        $it = new \App\Group(['name' => 'IT']);
        $it->save();

        $hr = new \App\Group(['name' => 'Human Resources']);
        $hr->save();

        $security = new \App\Group(['name' => 'Security']);
        $security->save();
    }
}
