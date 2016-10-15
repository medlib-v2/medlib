<?php

namespace Medlib\Console\Commands;

use Exception;
use Medlib\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class Init extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medlib:init';



    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install or upgrade Medlib';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            DB::connection();
        } catch (Exception $e) {
            $this->error('Unable to connect to database.');
            $this->error('Please fill valid database credentials into .env and rerun this command.');
            return;
        }

        $this->comment('Attempting to install or upgrade Medlib.');
        $this->comment('Remember, you can always install/upgrade manually following the guide here:');
        $this->info('📙  https://github.com/medlib-v2/medlib/wiki'.PHP_EOL);

        if (!config('app.key')) {
            $this->info('Generating app key');
            Artisan::call('key:generate');
        } else {
            $this->comment('App key exists -- skipping');
        }

        /**
        if (!config('jwt.secret')) {
            $this->info('Generating JWT secret');
            Artisan::call('medlib:generate-jwt-secret');
        } else {
            $this->comment('JWT secret exists -- skipping');
        }
        **/

        $this->info('Migrating database');
        Artisan::call('migrate', ['--force' => true]);

        if (!User::count()) {
            $this->info('Seeding initial data');
            Artisan::call('db:seed', ['--force' => true]);
        } else {
            $this->comment('Data seeded -- skipping');
        }

        $this->info('Executing npm install, gulp and whatnot');
        system('npm install');

        $this->comment(PHP_EOL.'🎆  Success! You can now run Medlib from localhost with `php artisan serve`.');
        $this->comment('Again, for more configuration guidance, refer to');
        $this->info('📙  https://github.com/medlib-v2/medlib/wiki.');
        $this->comment('WIKI ROCKS WIKI RULES.');
        $this->comment('KTHXBYE.');
    }
}
