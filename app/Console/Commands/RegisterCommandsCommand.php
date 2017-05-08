<?php

namespace Medlib\Console\Commands;

use Illuminate\Console\Command;

/**
 * Suppress all rules containing "unused" in this
 * class RegisterCommandsCommand
 *
 * @SuppressWarnings("unused")
 */
class RegisterCommandsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medlib:register-commands';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register commands in kernel.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
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
     * @return void
     */
    public function handle()
    {
        /**
         * Path to console commands
         */
        $path = "app/Console/Commands/";
        /**
         * Get array of console command file names
         */
        $arr = scandir($path);

        //$arr = $this->filesOnly($arr);
        /**
         * Get file names exclusing directories and dots
         */
        for ($i = 0; $i < sizeof($arr); $i++) {
            if (preg_match('/[.]php/', $arr[$i], $match)) {
                $files[] = preg_replace('/.php$/', '', $arr[$i]);
            }
        }
        /**
         * Sort file names to order their order in Kernel.php
         */
        sort($files);

        /**
         * Kernel to keep track of console commands implemented
         */
        $fileName = "app/Console/Kernel.php";

        /**
         * Get contents of the file
         */
        $contents = file_get_contents($fileName);
        $src = '';

        /**
         * Create string of console commands
         */
        foreach ($files as $file) {
            $src .= "\t\tCommands\\" . $file . "::class,\n";
        }

        /**
         * Replace current list of console commands with string
         */

        $contents = preg_replace("/protected [$]commands = \[.*?\];/is", "protected \$commands = [\n$src\t];", $contents);
        file_put_contents($fileName, $contents);
    }
}
