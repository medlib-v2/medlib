<?php

namespace Medlib\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\ComposerScripts;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeModelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medlib:make-model
                            {model : (required) Model name}
                            {--request : Make a new FormRequest from this Model name}
                            {--controller : Make new Controller from this Model name}
                            {--migration : Create new Migration file from this Model name}
                            {--faker : Create new Model Faker file from this Model name}
                            {--seed : Create new Seeder file from this Model name}';

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
     * @param $x
     * @param $min
     * @param $max
     * @return bool
     */
    protected function between($x, $min, $max)
    {
        if ($x >= $min) {
            if ($x <= $max) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $s
     * @param $model
     * @return mixed
     */
    protected function replace($s, $model)
    {
        /**
         * Split string into words with uppercase characters as delimiters, i.e., AlphaBeta => [Alpha, Beta]
         */
        $k = -1;
        $tableModel = '';
        $words = [];
        $model = ucfirst($model);
        $tableModel = snake_case($model);
        $usePath = preg_replace('~/~', '\\', ucwords('Medlib\\Models'));
        $s = preg_replace('/{{use_path}}/', $usePath, $s);
        $s = preg_replace('/{{model_singular}}/', str_singular($model), $s);
        $s = preg_replace('/{{table_model_plural_lowercase}}/', strtolower(str_plural($tableModel)), $s);
        $s = preg_replace('/{{model_plural_lowercase}}/', strtolower(str_plural($model)), $s);
        $s = preg_replace('/{{model_plural}}/', str_plural($model), $s);

        return $s;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
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

        $s = file_get_contents('app/Console/Commands/stubs/Model.stub');
        $s = $this->replace($s, $model);
        $output = $modelPath . str_singular($model) . '.php';

        file_put_contents($output, $s);
    }

    /**
     * @param $model
     */
    protected function makeRequest($model)
    {
        $s = file_get_contents('app/Console/Commands/stubs/RequestForm.stub');
        $s = $this->replace($s, $model);
        $output = "app/Http/Requests/" . str_plural($model) . 'Request.php';
        file_put_contents($output, $s);
    }
    /**
     * @param $model
     */
    protected function makeController($model)
    {
        $s = file_get_contents('app/Console/Commands/stubs/Controller.stub');
        $s = $this->replace($s, $model);
        $output = "app/Http/Controllers/" . str_plural($model) . 'Controller.php';
        file_put_contents($output, $s);
    }

    /**
     * @param $model
     */
    protected function makeMigration($model)
    {
        $s = file_get_contents('app/Console/Commands/stubs/Migration.stub');
        $s = $this->replace($s, $model);
        $output = "database/migrations/" . date('Y_m_d_his') . "_create_" . strtolower(str_plural($model)) . '_table.php';
        file_put_contents($output, $s);
    }

    /**
     * @param $model
     */
    protected function makeFaker($model)
    {
        $s = file_get_contents('app/Console/Commands/stubs/ModelFactory.stub');
        $s = $this->replace($s, $model);
        $output = 'database/factories/ModelFactory.php';
        file_put_contents($output, $s, FILE_APPEND);
    }

    /**
     * @param $model
     */
    protected function makeSeeder($model)
    {
        $s = file_get_contents('app/Console/Commands/stubs/Seeder.stub');
        $s = $this->replace($s, $model);
        $output = "database/seeds/" . str_plural($model) . 'TableSeeder.php';
        file_put_contents($output, $s);

        /**
         * Add seeder to DatabaseSeeder
         */
        $this->call('medlib:refactor-seeder');
    }
}
