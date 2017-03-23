<?php

use Medlib\Models\Message;
use Illuminate\Database\Seeder;
use \Medlib\Models\Conversation;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Conversation::class, 25)->create()->each(
            function($conversation) {
                $conversation->messages()->save(
                    factory(Message::class)->create()
                );
            }
        );
    }
}
