<?php

namespace Medlib\Console\Commands;

use Illuminate\Filesystem\Filesystem;

/**
 * Suppress all rules containing "unused" in this
 * class MakeVueComponentCommand
 *
 * @SuppressWarnings("unused")
 */
class MakeVueComponentCommand extends VueCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vue:component {name} {--empty} {--path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Vue js component file.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filesystem = new Filesystem();
        $name = $this->argument('name').'.vue';
        $path = $this->createPath($filesystem, 'component');
        $fullPath = resource_path("{$path}/{$name}");
        $this->checkFileExists($filesystem, $fullPath, $name);
        $stub = $this->getStub($filesystem);
        $filesystem->put($fullPath, $stub);
        $this->info("Component {$name} succesfully created.");
    }

    /**
     * Get and return stub.
     *
     * @param Filesystem $filesystem
     *
     * @return string
     */
    protected function getStub(Filesystem $filesystem)
    {
        $fileName = $this->option('empty') ? 'EmptyComponent' : 'Component';
        return $filesystem->get(__DIR__.'/stubs/'.$fileName.'.vue');
    }
}
