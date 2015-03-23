<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class PaginationServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		Paginator::currentPathResolver(function()
		{
			return $this->app['request']->fullUrl();
		});

		Paginator::currentPageResolver(function()
		{
			return $this->app['request']->input('page');
		});
	}

}
