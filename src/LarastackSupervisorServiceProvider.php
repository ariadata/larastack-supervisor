<?php

namespace Ariadata\LarastackSupervisor;

use Illuminate\Support\ServiceProvider;

class LarastackSupervisorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
	    $this->mergeConfigFrom(
		    dirname(__DIR__) . '/config/larastack-supervisor.php',
		    'larastack-supervisor'
	    );
	    $this->app->alias('larastack-supervisor', LarastackSupervisor::class);
		$this->app->singleton('larastack-supervisor', function () {
			return new LarastackSupervisor();
		});
	    $commands = array_map(fn($command) => 'Ariadata\LarastackSupervisor\Console\Commands\\' . basename($command, '.php'), glob(__DIR__ . '/Console/Commands/*.php'));
	    $this->commands($commands);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
	    $this->publishes([
		    dirname(__DIR__) . '/config/larastack-supervisor.php' => config_path('larastack-supervisor.php'),
	    ]);
    }
}
