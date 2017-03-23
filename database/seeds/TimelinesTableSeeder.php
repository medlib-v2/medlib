<?php

use Medlib\Models\User;
use Medlib\Models\Page;
use Medlib\Models\Group;
use Medlib\Models\Profile;
use Medlib\Models\Timeline;
use Illuminate\Database\Seeder;

class TimelinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account = Timeline::firstOrNew(['username' => 'admin']);
        $account->username = 'admin';
        $account->name = 'Admin Medlib Team';
        $account->type = 'user';
        $account->save();

        $user = User::create([
            'timeline_id' => $account->id,
            'email' => 'admin@medlib.app',
            'username' => 'admin',
            'password' => bcrypt("secret1983"),
            'first_name' => 'Admin',
            'last_name' => 'Medlib Team',
            'profession' => 'student',
            'date_of_birth' => '',
            'gender' => 'male',
            'activated' => true,
            'account_type' => false,
            'user_avatar' => "https://www.gravatar.com/avatar/" . md5(strtolower('admin@medlib.app')),
            'remember_token' => str_random(32)
        ]);

        $user->profile()->save(
            factory(Profile::class)->make()
        );

        $user_settings = [
            'user_id' => $user->id,
            'confirm_follow' => 'no',
            'follow_privacy' => 'everyone',
            'comment_privacy' => 'everyone',
            'timeline_post_privacy' => 'only_follow',
            'post_privacy' => 'everyone',];

        DB::table('user_settings')->insert($user_settings);

        $user->roles()->attach(1);

        /**
         * Populate dummy accounts
         */
        factory(Timeline::class, 90)->create()
            ->each(function ($timeline) {
                $faker = Faker\Factory::create();

                if ($timeline->id < 40) {
                    $email = $faker->unique()->email;
                    list($firstName, $lastName) = explode(" ", $timeline->name, 5);
                    //Seeding users
                    $user = User::create([
                        'timeline_id' => $timeline->id,
                        'email' => $email,
                        'username' => $timeline->username,
                        'password' => bcrypt("secret1983"),
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'profession' => $faker->randomElement(['student', 'researcher', 'teacher']),
                        'date_of_birth' => $faker->date,
                        'gender' => $faker->randomElement(['male', 'female']),
                        'activated' => true,
                        'account_type' => false,
                        'user_avatar' => "https://www.gravatar.com/avatar/" . md5(strtolower($email)) . "?d=identicon",
                        'remember_token' => str_random(32)
                    ]);

                    $user->profile()->save(
                        factory(Profile::class)->make()
                    );

                    //Seeding user settings
                    $user_settings = [
                        'user_id' => $user->id,
                        'confirm_follow' => 'no',
                        'follow_privacy' => 'everyone',
                        'comment_privacy' => 'everyone',
                        'timeline_post_privacy' => 'only_follow',
                        'post_privacy' => 'everyone'
                    ];

                    DB::table('user_settings')->insert($user_settings);
                    $timeline->type = 'user';
                    $timeline->save();
                } elseif ($timeline->id < 60) {
                    $page = Page::create([
                        'timeline_id' => $timeline->id,
                        'address' => $faker->address,
                        'about' => $faker->text,
                        'category_id' => $faker->numberBetween($min = 1, $max = 20),
                        'message_privacy' => 'everyone',
                        'timeline_post_privacy' => 'everyone',
                    ]);
                    $timeline->type = 'page';
                    $timeline->save();

                    //Seeding page likes
                    $likes = $faker->randomElements(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20'], $faker->numberBetween(1, 3));

                    $page->likes()->sync($likes);

                    //Seeding page users
                    $users = $faker->randomElements(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20'], $faker->numberBetween(1, 3));

                    $sycnUsers = [];
                    foreach ($users as $key => $value) {
                        $sycnUsers[$value] = ['role_id' => $faker->numberBetween(1, 3), 'active' => 1];
                    }

                    $page->users()->sync($sycnUsers);
                } else {
                    $group = Group::create([
                        'timeline_id' => $timeline->id,
                        'type' => $faker->randomElement($array = ['open', 'closed', 'secret']),
                        'about' => $faker->text,
                        'member_privacy' => 'everyone',
                        'post_privacy'   => 'everyone',
                    ]);
                   $timeline->type = 'group';
                   $timeline->save();

                //Seeding group users
                $users = $faker->randomElements(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20'], $faker->numberBetween(1, 3));

                   $sycnUsers = [];
                   foreach ($users as $key => $value) {
                       $sycnUsers[$value] = ['role_id' => $faker->numberBetween(1, 3), 'status' => 'approved'];
                   }

                   $group->users()->sync($sycnUsers);
               }
            });

        //Seeding Followers
        $faker = Faker\Factory::create();
        $users = User::all();

        foreach ($users as $user) {
            $followers = $faker->randomElements(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38'], $faker->numberBetween(1, 3));

            $sycnFollowers = [];
            foreach ($followers as $key => $value) {
                $sycnFollowers[$value] = ['status' => 'approved'];
            }

            $user->followers()->sync($sycnFollowers);
        }
    }
}
