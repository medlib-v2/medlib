<?php

namespace Medlib\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;

class MakeVueViewCommand extends VueCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vue:view {name : (required) The name of the component view}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Vue js component and route file.';

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the component view']
        ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filesystem = new Filesystem();
        $name = $this->argument('name');
        $component = $name.'/components/'. ucfirst(str_singular($name)) . '.vue';
        $route = $name.'/routes/index.js';

        $path = $this->createPath($filesystem, 'view');

        $this->makePath($name, $path, $filesystem);

        $fullComponentPath = resource_path("{$path}/{$component}");
        $fullRoutPath = resource_path("{$path}/{$route}");
        $this->checkFileExists($filesystem, $fullComponentPath, $component);
        $this->checkFileExists($filesystem, $fullRoutPath, $route);

        $stubComponent = $this->getStub($filesystem, 'ComponentView.vue');
        $stubView = $this->replace($stubComponent, $name);
        $filesystem->put($fullComponentPath, $stubView);

        $stubRoute = $this->getStub($filesystem, 'route.js.stub');
        $route = $this->replace($stubRoute, $name);
        $filesystem->put($fullRoutPath, $route);

        $this->info("Component {$name} succesfully created.");
    }

    protected function makePath($name , $path, Filesystem $filesystem){
        $component = "{$path}/{$name}/components";
        $route = "{$path}/{$name}/routes";
        $this->buildPathFromArray($component, $filesystem);
        $this->buildPathFromArray($route, $filesystem);
    }

    /**
     * @param $stub
     * @param $name
     * @return mixed
     */
    protected function replace($stub, $name)
    {
        $name = ucfirst($name);

        $stub = preg_replace('/{{view_name}}/', str_singular($name), $stub);
        $stub = preg_replace('/{{view_name_lowercase}}/', strtolower(str_singular($name)), $stub);

        return $stub;
    }

    /**
     * Get and return stub.
     *
     * @param Filesystem $filesystem
     * @param $fileName
     *
     * @return string
     */
    protected function getStub(Filesystem $filesystem, $fileName)
    {
        return $filesystem->get(__DIR__.'/stubs/'. $fileName);
    }
}
