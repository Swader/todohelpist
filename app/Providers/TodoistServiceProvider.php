<?php namespace Todohelpist\Providers;

use Illuminate\Support\ServiceProvider;
use Todohelpist\Services\Todoist;

class TodoistServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Todohelpist\Services\Todoist', function ($app) {
            return new Todoist(getenv('TODOIST_API_BASE'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['Todohelpist\Services\Todoist'];
    }

}
