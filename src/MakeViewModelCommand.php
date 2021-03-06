<?php

namespace Takemo101\LaravelSimpleVM;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeViewModelCommand extends GeneratorCommand
{
    use CreatesMatchingTest;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'make:svm {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make simple view model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'ViewModel';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../stub/ViewModel.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        /**
         * @var ViewModelConfig
         */
        $vmConfig = $this->getLaravel()->make(ViewModelConfig::class);

        /**
         * @var \Illuminate\Foundation\Application
         */
        $laravel = $this->getLaravel();

        $path = $vmConfig->hasPath() ? $vmConfig->getPath() :
            $laravel->path();

        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        $replace = (string)str_replace('\\', '/', $name);

        return $path . '/' . $replace . '.php';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        if ($this->isCustomNamespace()) {
            return $rootNamespace;
        }

        /**
         * @var ViewModelConfig
         */
        $vmConfig = $this->getLaravel()->make(ViewModelConfig::class);

        return $vmConfig->getCombinedNamespace($rootNamespace);
    }

    /**
     * is custom namespace
     *
     * @return boolean
     */
    protected function isCustomNamespace(): bool
    {
        return Str::contains($this->getNameInput(), '/');
    }
}
