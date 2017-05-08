<?php

namespace Medlib\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\ComposerScripts;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Suppress all rules containing "unused" in this
 * class MakeModelCommand
 *
 * @SuppressWarnings("unused")
 */
class MakeModelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medlib:make-model
                            {model : (required) Model name}
                            {--r|--request : Make a new FormRequest from this Model name}
                            {--c|--controller : Make new Controller from this Model name}
                            {--m|--migration : Create new Migration file from this Model name}
                            {--f|--faker : Create new Model Faker file from this Model name}
                            {--s|--seed : Create new Seeder file from this Model name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make custom model';

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Foundation\ComposerScripts
     */
    protected $composer;

    /**
     * Create a new command instance.
     *
     * @param ComposerScripts $composer
     */
    public function __construct(ComposerScripts $composer)
    {
        parent::__construct();

        $this->composer = $composer;
        //$this->composer->dumpAutoloads();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['model', InputArgument::REQUIRED, 'Model name', 'User']
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
            ['request', InputOption::VALUE_NONE, 'Make a new FormRequest from this Model name'],
            ['controller', InputOption::VALUE_NONE, 'Make new Controller from this Model name'],
            ['migration', InputOption::VALUE_NONE, 'Create new Migration file from this Model name'],
            ['facker', InputOption::VALUE_NONE, 'Create new Model Faker file from this Model name'],
            ['seed', InputOption::VALUE_NONE, 'Create new Seeder file from this Model name'],
        ];
    }

    /**
     * @param int $src
     * @param int $min
     * @param int $max
     * @return bool
     */
    protected function between(int $src, int $min, int $max)
    {
        if ($src >= $min) {
            if ($src <= $max) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $src
     * @param string $model
     * @return mixed
     */
    protected function replace(string $src, string $model)
    {
        /**
         * Split string into words with uppercase characters as delimiters, i.e., AlphaBeta => [Alpha, Beta]
         */
        $key = -1;
        $tableModel = '';
        $words = [];
        $model = ucfirst($model);
        $tableModel = snake_case($model);
        $usePath = preg_replace('~/~', '\\', ucwords('Medlib\\Models'));
        $src = preg_replace('/{{use_path}}/', $usePath, $src);
        $src = preg_replace('/{{model_singular}}/', str_singular($model), $src);
        $src = preg_replace('/{{table_model_plural_lowercase}}/', strtolower(str_plural($tableModel)), $src);
        $src = preg_replace('/{{model_plural_lowercase}}/', strtolower(str_plural($model)), $src);
        $src = preg_replace('/{{model_plural}}/', str_plural($model), $src);

        return $src;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $model = $this->argument('model');

        $this->makeModel($model);
        /**
         * {--request} Form Request
         */
        if ($this->option('request')) {
            $this->makeRequest($model);
        }

        /**
         * {--controller} Controller
         */
        if ($this->option('controller')) {
            $this->makeController($model);
        }

        /**
         * {--migration} Migration
         */
        if ($this->option('migration')) {
            $this->makeMigration($model);
        }

        /**
         * {--faker} ModelFaker
         */
        if ($this->option('faker')) {
            $this->makeFaker($model);
        }

        /**
         * {--seed} Seeder
         */
        if ($this->option('seed')) {
            $this->makeSeeder($model);
        }
    }

    /**
     * @param $model
     */
    protected function makeModel($model)
    {
        $modelPath = 'app/Models/';

        $src = file_get_contents('app/Console/Commands/stubs/Model.stub');
        $src = $this->replace($src, $model);
        $output = $modelPath . ucfirst(str_singular($model)) . '.php';

        file_put_contents($output, $src);
    }

    /**
     * @param $model
     */
    protected function makeRequest($model)
    {
        $src = file_get_contents('app/Console/Commands/stubs/RequestForm.stub');
        $src = $this->replace($src, $model);
        $output = "app/Http/Requests/" . ucfirst(str_plural($model)) . 'Request.php';
        file_put_contents($output, $src);
    }
    /**
     * @param $model
     */
    protected function makeController($model)
    {
        $src = file_get_contents('app/Console/Commands/stubs/Controller.stub');
        $src = $this->replace($src, $model);
        $output = "app/Http/Controllers/" . ucfirst(str_plural($model)) . 'Controller.php';
        file_put_contents($output, $src);
    }

    /**
     * @param $model
     */
    protected function makeMigration($model)
    {
        $src = file_get_contents('app/Console/Commands/stubs/Migration.stub');
        $src = $this->replace($src, $model);
        $output = "database/migrations/" . date('Y_m_d_his') . "_create_" . strtolower(str_plural($model)) . '_table.php';
        file_put_contents($output, $src);
    }

    /**
     * @param $model
     */
    protected function makeFaker($model)
    {
        $src = file_get_contents('app/Console/Commands/stubs/ModelFactory.stub');
        $src = $this->replace($src, $model);
        $output = 'database/factories/ModelFactory.php';
        file_put_contents($output, $src, FILE_APPEND);
    }

    /**
     * @param $model
     */
    protected function makeSeeder($model)
    {
        $src = file_get_contents('app/Console/Commands/stubs/Seeder.stub');
        $src = $this->replace($src, $model);
        $output = "database/seeds/" . ucfirst(str_plural($model)) . 'TableSeeder.php';
        file_put_contents($output, $src);

        /**
         * Add seeder to DatabaseSeeder
         */
        $this->call('medlib:refactor-seeder');
    }
}
