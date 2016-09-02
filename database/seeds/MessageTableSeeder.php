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
            factory(App\Message::class, 5)->make()->each(function($message) use($user) {
                $message->sender_id = $user->id;
                $message->receiver_id = $user->id;

                $message->save();
            });
        });
    }
}
