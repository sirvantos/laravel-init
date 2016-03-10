<?php namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class TransformerServiceProvider extends ServiceProvider
{
	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		$api = app('Dingo\Api\Transformer\Factory');

		$api->register('App\Entities\Movie', 'App\Lib\Transformers\Movie');
	}
}