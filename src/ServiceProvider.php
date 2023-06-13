<?php

namespace Ashin33\QnApi;

use Ashin33\QnApi\QnApi;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
	protected $defer = true;

	/**
	 * Bootstrap the application services.
	 */
	public function boot()
	{
		$this->publishes([
			__DIR__ . '/../config/qn-api.php' => config_path('qn-api.php')
		], 'qn-api');
	}

	public function register()
	{
		$this->mergeConfigFrom(__DIR__.'/../config/qn-api.php', 'qn-api');

		$this->app->singleton(QnApi::class, function () {
			return new QnApi(
				config('qn-api.inst_id'),
				config('qn-api.secret'),
				config('qn-api.qn_public_key'),
				config('qn-api.merchant_private_key'),
				config('qn-api.host')
			);
		});

		$this->app->alias(QnApi::class, 'qn-api');
	}

	public function provides()
	{
		return [QnApi::class, 'qn-api'];
	}
}