<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 50)->create()->each(function($user){

            $departments = App\Group::all();
            $index = rand(0, 3);
            $user->groups()->save($departments[$index]);
        });

    }
}
