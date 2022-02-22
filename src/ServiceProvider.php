<?php

namespace Takemo101\LaravelSimpleVM;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Takemo101\SimpleVM\ViewModelDataAdapterCreator;

/**
 * this package service provider class
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * @var string
     */
    protected $config = 'simple-vm';

    /**
     * @var string
     */
    protected $baseDirectory;

    public function __construct($app)
    {
        parent::__construct($app);

        $this->baseDirectory = dirname(__DIR__, 1);
    }

    public function register(): void
    {
        $this->mergeConfigFrom("{$this->baseDirectory}/config/config.php", $this->config);

        $this->app->singleton(ViewModelConfig::class, function ($app) {
            $config = $app['config'];
            return new ViewModelConfig(
                $config->get("{$this->config}.namespace"),
                $config->get("{$this->config}.path"),
            );
        });
    }

    public function boot(): void
    {
        $this->bootSimpleViewModel();
        $this->bootConsoleCommands();
    }

    /**
     * boot simple view model
     *
     * @return void
     */
    protected function bootSimpleViewModel(): void
    {
        ViewModelDataAdapterCreator::setDefaultCallableResolver(
            new LaravelCallableResolver($this->app),
        );
    }

    /**
     * boot commands
     *
     * @return void
     */
    protected function bootConsoleCommands(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            MakeViewModelCommand::class,
        ]);
    }
}
