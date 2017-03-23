<?php

namespace Medlib\Console\Commands;

use Illuminate\Filesystem\Filesystem;

class MakeVueMixinCommand extends VueCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vue:mixin {name} {--empty} {--path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Vue js mixin file.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filesystem = new Filesystem();
        $name = $this->argument('name').'.js';
        $path = $this->createPath($filesystem, 'mixin');
        $fullPath = resource_path("{$path}/{$name}");
        $this->checkFileExists($filesystem, $fullPath, $name);
        $stub = $this->getStub($filesystem);
        $filesystem->put($fullPath, $stub);
        $this->info("Mixin {$name} succesfully created.");
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
        $fileName = $this->option('empty') ? 'EmptyMixin' : 'Mixin';

        return $filesystem->get(__DIR__.'/stubs/'.$fileName.'.js');
    }
}
