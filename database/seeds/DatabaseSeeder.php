<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

    protected $tables = [
        'authors',
        'books',
        'books_media',
        'books_subject',
        'categories',
        'editions',
        'favorites',
        'feeds',
        'friends',
        'friend_requests',
        'messages',
        'message_responses',
        'message_response_user',
        'message_user',
        'password_resets',
        'publishers',
        'users'
    ];

    protected $seeders = [
        AuthorsTableSeeder::class,
        BookTableSeeder::class,
        CategoryTableSeeder::class,
        EditionTableSeeder::class,
        FeedTableSeeder::class,
        FriendRequestTableSeeder::class,
        MessageResponsesTableSeeder::class,
        MessageResponseUserTableSeeder::class,
        MessageUserTableSeeder::class,
        MessagesTableSeeder::class,
        PublisherTableSeeder::class,
        UserTableSeeder::class
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        Model::unguard();

        $this->cleanDatabase();

        foreach ($this->seeders as $seedClass) {
            $this->call($seedClass);
        }

        /**
        $this->call(UserTableSeeder::class);
        $this->call(FeedTableSeeder::class);
        $this->call(FriendRequestTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(MessageUserTableSeeder::class);
        $this->call(MessageResponsesTableSeeder::class);
        $this->call(MessageResponseUserTableSeeder::class);
        $this->call(AuthorsTableSeeder::class);
        */
        Model::reguard();

    }

    /**
     * Clean out the database for new seed generation
     */
    public function cleanDatabase() {

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        foreach ($this->tables as $table) {

            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
