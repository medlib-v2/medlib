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
        'conversations',
        'password_resets',
        'publishers',
        'settings',
        'roles',
        'users',
        'profiles',
        'role_user',
        'permissions',
        'permission_role',
        'timelines',
        'comment_likes',
        'media',
        'followers',
    ];

    protected $localSeeders = [
        AuthorsTableSeeder::class,
        BookTableSeeder::class,
        CategoryTableSeeder::class,
        EditionTableSeeder::class,
        LanguageTableSeeder::class,
        PublisherTableSeeder::class,
        //UserTableSeeder::class,
        MediumTableSeeder::class,
        RolesTableSeeder::class,
        TimelinesTableSeeder::class,
        FriendRequestTableSeeder::class,
        SettingsTableSeeder::class,
        HashtagsTableSeeder::class,
        AnnouncementsTableSeeder::class,
        FeedTableSeeder::class,
        CommentsTableSeeder::class,
        StaticpageTableSeeder::class,
        MessagesTableSeeder::class,
	];

    protected $productionSeeders = [
        //CategoriesTableSeeder::class,
        RolesTableSeeder::class,
        StaticpageTableSeeder::class,
        ProductionSeeder::class,
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

        $seeders = (Config::get('app.env') == 'local') ? $this->localSeeders : $this->productionSeeders;

        foreach ($seeders as $seedClass) {
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
