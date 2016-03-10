<?php

namespace App\Providers;

use App\Lib\Fractal\Serializers\Dynatable;
use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager as Manager;

/**
 * Class FractalManagerServiceProvider
 * @package App\Providers
 *
 * Dingo API doesn't use fractal provider  to initialize instance so no way to customize it
 * through config
 *
 * Provider add bind to fractal manager to set Dynatable serializer
 */
class FractalManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
	    $this->app->bind(Manager::class, function ($app) {
			$manager = new Manager();
		    $manager->setSerializer(new Dynatable());

		    return $manager;
	    });
    }
}
