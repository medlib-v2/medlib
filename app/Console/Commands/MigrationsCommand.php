<?php

namespace Medlib\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Suppress all rules containing "unused" in this
 * class MigrationsCommand
 *
 * @SuppressWarnings("unused")
 */
class MigrationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medlib:show
                            {migrations : (required) Show all migration schemas}
                            {--write : Output migrations to text file (alternative bash > output)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show all migration schemas.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['migrations', InputArgument::REQUIRED, '(required) Show all migration schemas']
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['write', InputOption::VALUE_NONE, 'Output migrations to text file (alternative bash > output']
        ];
    }

    /**
     * @param $files
     * @return array
     */
    protected function filesOnly($files)
    {
        do {
            $done = true;
            for ($i = 0; $i < sizeof($files); $i++) {
                if (preg_match('/^\./', $files[$i], $match)) {
                    unset($files[$i]);
                    $done = false;
                }
            }
            $files = array_values($files);
        } while (!$done);
        return $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $migrations = $this->argument('migrations');

        /**
         * Path to database migration files
         */
        $path = "database/migrations/";

        /**
         * Scan directory for database migration files
         */
        $files = scandir($path);
        $files = $this->filesOnly($files);

        /**
         * Get only migration files excluding directories and dots
         */
        for ($i = 0; $i < sizeof($files); $i++) {
            if (preg_match('/^[.]/', $files[$i], $match)) {
                unset($files[$i]);
            }
        }

        /**
         * Sort files to order functions on output
         */
        sort($files);

        $src = '';
        foreach ($files as $file) {
            $contents = file_get_contents($path . $file);
            /**
             * Fetch the schema from file contents
             */
            if (preg_match('/(Schema::.*?\}\)\;)/is', $contents, $match)) {
                $src .= $match[1];
            }
            $src .=  chr(10) . chr(10);
        }

        /**
         * Output to file?
         */
        if ($this->option('write')) {
            $output = $path . strtolower(config('app.name')).'.migrations.txt';
            file_put_contents($output, $src);
            $this->info('Output');
            $this->line($output);
        } else {
            /**
             * Show each line of schema (this is not a diagnostic line out)
             */
            $this->line($src);
        }
    }
}
