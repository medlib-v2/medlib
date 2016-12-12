<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    protected $tables = [
        'authors',
        'books',
        'books_media',
        'books_subject',
        'categories',
        'comments',
        'editions',
        'favorites',
        'feeds',
        'friends',
        'friend_requests',
        'languages',
        'likes',
        'messages',
        'message_responses',
        'message_response_user',
        'message_user',
        'password_resets',
        'publishers',
        'users',
    ];

    protected $seeders = [
        UserTableSeeder::class,
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
        LanguageSeeder::class
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->cleanDatabase();

        foreach ($this->seeders as $seedClass) {
            $this->call($seedClass);
        }
        
        Model::reguard();
    }

    /**
     * Clean out the database for new seed generation
     */
    public function cleanDatabase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        foreach ($this->tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
