<?php

use Illuminate\Database\Seeder;

class MessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::get()->each(function($user){
            $contacts = [];
            $groups = $user->groups;
            foreach($groups as $group){
                $contacts = array_merge($contacts, $group->users->all());
            }


            factory(App\Message::class, 10)->make()->each(function($message) use($user, $contacts) {
                $message->sender_id = $user->id;

                // Get random index of the $contacts array in order to access a receiver
                $randUserIndex = rand(0, count($contacts) - 1);
                $message->receiver_id = $contacts[$randUserIndex]->id;

                $message->save();
            });
        });
    }
}
