<?php

namespace Medlib\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Medlib\Console\Commands\Traits\Paths;
use Medlib\Exceptions\ResourceAlreadyExists;

class VueCommand extends Command
{
    use Paths;

    /**
     * Create path for file.
     *
     * @param Filesystem $filesystem
     * @param string     $type       File type.
     *
     * @return string
     */
    protected function createPath(Filesystem $filesystem, $type)
    {
        $customPath = $this->hasOption('path') ? $this->option('path') : null;

        $defaultPath = config("vue.paths.{$type}s");

        $path = $customPath !== null ? $customPath : $defaultPath;

        $this->buildPathFromArray($path, $filesystem);

        return $path;
    }

    protected function checkFileExists(Filesystem $filesystem, $path, $name)
    {
        if ($filesystem->exists($path)) {
            throw ResourceAlreadyExists::fileExists($name);
        }
    }
}
