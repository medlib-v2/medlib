<?php

namespace Medlib\Console\Commands;

use Illuminate\Console\Command;

class DatabaseSeederCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medlib:refactor-seeder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update database seeder.';

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
        /**
         * Path to ModelTableSeeder that extends seeder
         */
        $pathSeeds = "database/seeds/";

        /**
         * Get all table seeders files name in path
         */
        $arr = scandir($pathSeeds);

        /**
         * Get array of only table seeders files name excluding directories and dots
         */
        for ($i = 0; $i < sizeof($arr); $i++) {
            if (preg_match('/TableSeeder.php/', $arr[$i], $match)) {
                $files[] = preg_replace('/.php$/', '', $arr[$i]);
            }
        }

        /**
         * Sort files to order table seeder output in DatabaseSeder.php
         */
        sort($files);

        /**
         * DatabaseSeeder.php script that serves as a kernel for seeders
         */
        $fileName = "database/seeds/DatabaseSeeder.php";

        /**
         * Get contents of file
         */
        $contents = file_get_contents($fileName);

        $s = "";

        foreach ($files as $file) {
            $s .= "\t\t" . $file . "::class,\n";
        }

        /**
         * Replace existing calls with string
         */
        $contents = preg_replace("/protected [$]seeders = \[.*?\];/is", "protected \$seeders = [\n$s\t];", $contents);
        file_put_contents($fileName, $contents);
    }
}
