<?php

/*
 * This file is part of Fixhub.
 *
 * Copyright (C) 2016 Fixhub.org
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Medlib\Console\Commands;

use Carbon\Carbon;
//use Medlib\Models\Deployment;
use Medlib\Events\RestartSocketServer;
use Illuminate\Support\Facades\App;

/**
 * A console command for updating the installation.
 */
class UpdateCommand extends InstallCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medlib:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executes any updates needed for the application.';

    /**
     * Create a new command instance.
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
        if (!$this->verifyInstalled() ||
            $this->hasRunningDeployments() ||
            $this->composerOutdated() ||
            !$this->checkRequirements()) {
            return -1;
        }

        if (!App::isDownForMaintenance()) {
            $this->error(trans('app.not_down'));

            if (!$this->confirm(trans('app.switch_down'))) {
                return;
            }

            $this->call('down');
        }

        $this->backupDatabase();
        $this->updateConfiguration();
        $this->migrate();
        $this->optimize();
        $this->restartQueue();
        $this->restartSocket();

        /**
         * If we prompted the user to bring the app down, bring it back up
         */
        $this->call('up');
    }

    /**
     * Backup the database.
     *
     * @return void
     */
    protected function backupDatabase()
    {
        $date = Carbon::now()->format('Y-m-d H.i.s');

        $this->call('db:backup', [
            '--database'        => config('database.default'),
            '--destination'     => 'local',
            '--destinationPath' => $date,
            '--compression'     => 'gzip',
        ]);
    }

    /**
     * Checks for new configuration values in .env.example and copy them to .env.
     *
     * @return void
     */
    protected function updateConfiguration()
    {
        $config = [];

        /**
         * Read the current config values into an array for the writeEnvFile method
         */
        foreach (file(base_path('.env')) as $line) {
            $line = ltrim($line);

            if (empty($line)) {
                continue;
            }

            if ($this->isComment($line)) {
                continue;
            }

            $parts = explode('=', $line);

            $env   = strtolower($parts[0]);
            $value = trim($parts[1]);

            $section = substr($env, 0, strpos($env, '_'));
            $key     = substr($env, strpos($env, '_') + 1);

            $config[$section][$key] = $value;
        }

        /**
         * JWT secret needs to be generated if it is not already set
         */
        if (!isset($config['jwt']) || $config['jwt']['secret'] === 'changeme') {
            $config['jwt']['secret'] = $this->generateJWTKey();
        }

        /**
         * Backup the .env file, just in case it failed because we don't want to lose APP_KEY
         */
        copy(base_path('.env'), base_path('.env.prev'));

        /**
         * Copy the example file so that new values are copied
         */
        copy(base_path('.env.example'), base_path('.env'));

        /**
         * Write the file to disk
         */
        $this->writeEnvFile($config);

        /**
         * If the updated .env is the same as the backup remove the backup
         */
        if (md5_file(base_path('.env')) === md5_file(base_path('.env.prev'))) {
            unlink(base_path('.env.prev'));
        }
    }

    /**
     * Restarts the queues.
     *
     * @return void
     */
    protected function restartQueue()
    {
        $this->info('Restarting the queue');
        $this->line('');
        //$this->call('queue:flush');
        $this->call('queue:restart');
        $this->line('');
    }

    /**
     * Restarts the socket server.
     *
     * @return void
     */
    protected function restartSocket()
    {
        $this->info('Restarting the socket server');
        event(new RestartSocketServer);
    }

    /**
     * Checks if there are any running or pending deployments.
     *
     * @return bool
     */
    protected function hasRunningDeployments()
    {
        //
    }

    /**
     * Check if the composer autoload.php has been updated in the last 10 minutes,
     * if not we assume composer install has not be run recently.
     *
     * @return bool
     */
    protected function composerOutdated()
    {
        if (filemtime(base_path('vendor/autoload.php')) < strtotime('-10 minutes')) {
            if ($this->getLaravel()->environment() == 'local') {
                $this->block([
                    'Update not complete!',
                    PHP_EOL,
                    'Please run "composer update" and "yarn upgrade" before you continue.',
                ]);
                return true;
            }

            $this->block([
                'Update not complete!',
                PHP_EOL,
                'Please run "composer install --no-dev -o" and "yarn install --production" before you continue.',
            ]);

            return true;
        }

        return false;
    }

    /**
     * Ensures that Medlib has actually been installed.
     *
     * @return bool
     */
    private function verifyInstalled()
    {
        if (config('app.key') === false || config('app.key') === 'SomeRandomString') {
            $this->block([
                'Medlib has not been installed',
                PHP_EOL,
                'Please use "php artisan medlib:install" instead.',
            ]);

            return false;
        }

        return true;
    }

    /**
     * Determine if the line in the file is a comment, e.g. begins with a #.
     *
     * @param string $line
     *
     * @return bool
     */
    private function isComment($line)
    {
        $line = ltrim($line);
        return isset($line[0]) && $line[0] === '#';
    }
}
