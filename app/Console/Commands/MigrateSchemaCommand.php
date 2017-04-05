<?php

namespace Medlib\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Medlib\Services\SqlMigrations;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MigrateSchemaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:schema';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates individual migration files from a MYSQL DB.';

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
        $options = $this->option();
        $arguements = $this->argument();

        if (empty($arguements['db'])) {
            $this->error("The DB name is required.\n");
        } else {
            /**
             * make sure the DB exists
             */
            $databaseExists = DB::select("SHOW DATABASES LIKE '{$arguements['db']}'");

            if (count($databaseExists) === 0) {
                $this->error("The '{$arguements['db']}' database does NOT exist..\n");
            }
        }

        /**
         * can't use --only and --ignore together
         */
        if (!empty($options['only']) && !(empty($options['ignore']))) {
            $this->error("--only & --ignore can NOT be used together.  Choose one or the other.\n");
        }

        /**
         * ignore option
         */
        $ignoreTables = [];

        if (!empty($options['ignore'])) {
            $ignoreTables = explode(',', $options['ignore']);
        }

        /**
         * only option
         */
        $onlyTables = [];

        if (!empty($options['only'])) {
            $onlyTables = explode(',', $options['only']);
        }

        /**
         * run it
         */
        $migrate = new SqlMigrations;
        $migrate->ignore($ignoreTables);
        $migrate->only($onlyTables);
        $migrate->convert($arguements['db']);
        $migrate->write();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['db', InputOption::VALUE_REQUIRED, 'DB to build migration files from.'],
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
            ['only', null, InputOption::VALUE_OPTIONAL, 'Only create from these tables. Comma separated, no spaces.', null],
            ['ignore', null, InputOption::VALUE_OPTIONAL, 'Tables to skip. Comma separated, no spaces.', null],
        ];
    }
}
